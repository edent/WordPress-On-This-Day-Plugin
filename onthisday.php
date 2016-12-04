<?php
/*
Plugin Name: OnThisDay
Description: RSS feed of posts which occurred on this day in the past
*/

//	RSS of today's historic blog posts
//	Visible at example.com/?on_this_day

add_action( 'init', 'edent_on_this_day' );

function edent_on_this_day()
{
	if( isset( $_GET['on_this_day'] ) ) {
		if( isset( $_GET['month'] ) && isset( $_GET['day'] ) ) {
			$today = getdate(strtotime("2000-".$_GET['month']."-".$_GET['day']));
		} else {
			$today = getdate();
		}

		$args = array(
		   'date_query' => array(
		      array(
		         'month' => $today['mon'],
		         'day'   => $today['mday'],
		      ),
		   ),
		);
		$query = new WP_Query( $args );

		rss_encode($query);
		die();
	}
}

function rss_encode($data) {
	$today = getdate();
	$pubDate =  date("D, d M Y") . " 00:00:00 GMT";

	$rss = '<?xml version="1.0" encoding="UTF-8" ?>
	        <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	        <channel>
	               <title>On This Day</title>
	               <description></description>
	               <link>' . site_url() . '/?on_this_day</link>
	               <language>en-gb</language>';

	$posts = $data->get_posts();

	foreach($posts as $post) {
		// Do your stuff, e.g.
		$title= $post->post_title;
		$id	 = $post->ID;
		$link = get_permalink($id);
		$date = $post->post_date;
		$postDate = date("D, d M Y") . " " . date("h:i:s O", strtotime($date));
		$thumb = get_the_post_thumbnail($id, 'full');

		$archive = "From the " . date("F Y", strtotime($date)) . " archives: ";

		//	Only add an item if it is before *this year*
		//	AND before the current hour (prevents suddenly adding loads of posts)
		if (
		      ( intval(date("Y", strtotime($date))) <  intval($today['year'] ) ) &&
		      ( intval(date("H", strtotime($date))) <= intval($today['hours']) )
		) {
				$rss .= '<item>
				   <title>'  .html_entity_decode($archive . $title).'</title>
				   <link>'   .htmlspecialchars($link).'</link>
				   <description>
				      <![CDATA['.$thumb.']]>
				   </description>
				   <pubDate>'.$postDate.'</pubDate>
				   <guid>'   .htmlspecialchars($link).'</guid>
				</item>';
		}
	}

	$rss .= '</channel>
	</rss>';

	header('Content-Type: application/rss+xml');
	echo $rss;
}

