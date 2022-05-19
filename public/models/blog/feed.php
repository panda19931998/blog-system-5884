<?php
header("Content-Type: application/rss+xml; charset=utf-8");
//変数を設定
$blog_entry = array();
$blog_entrys = array();
$blog_category = array();
$blog_category_master = array();

//日付を取得
$date = new DateTime();
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
$today = $date->format('Y-m-d');

//記事を10件取得
$sql = "SELECT * FROM blog_entry WHERE blog_id = :blog_id AND client_id = :client_id  AND status = :status AND posting_date <= :posting_date LIMIT 0, 10 ";

$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id'],
	":status" => 1,
	":posting_date" => $today,
);
$stmt->execute($params);
$blog_entrys = $stmt->fetchAll();
?>
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<channel>
<title><?php echo $blog['blog_title'] ; ?></title>
<atom:link href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/feed/" rel="self" type="application/rss+xml" />
<link>http://b.blog-system-5884.localhost/<?php echo h($client_code); ?></link>
<description><?php echo $blog['blog_description'] ; ?></description>
<lastBuildDate><?php echo $blog['updated_at'] ; ?></lastBuildDate>
<language>ja</language>
<sy:updatePeriod>daily</sy:updatePeriod>
<sy:updateFrequency>1</sy:updateFrequency>
<generator></generator>
<xhtml:link rel="alternate" media="handheld" type="text/html" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/feed/" />
<?php foreach ($blog_entrys as $blog_entry):?>
<?php
			//カテゴリーを取得

			$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_entry_id =:blog_entry_id ";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_id" => $blog_id,
				":client_id" => $client['id'],
				":blog_entry_id" => $blog_entry['id']
			);
			$stmt->execute($params);
			$blog_category = $stmt->fetch();


			$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id AND id = :id ";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_id" => $blog_id,
				":client_id" => $client['id'],
				":id" => $blog_category['blog_category_master_id']
			);
			$stmt->execute($params);
			$blog_category_master = $stmt->fetch();
?>
<item>
<title><?php echo $blog_entry['title'] ; ?></title>
<?php if (empty($blog_entry['slug'])): ?>
<link>http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo $blog_entry['blog_entry_code'] ; ?>.html</link>
<?php else : ?>
<link>http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo $blog_entry['slug'] ; ?>.html</link>
<?php endif; ?>
<comments></comments>
<pubDate><?php echo $blog_entry['posting_date'] ; ?></pubDate>
<dc:creator><![CDATA[<?php echo $blog['blog_author_name'] ; ?>]]></dc:creator>
<category><![CDATA[<?php echo $blog_category_master['category_name'] ; ?>]]></category>
<?php if (empty($blog_entry['slug'])): ?>
<guid isPermaLink="false">http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo $blog_entry['blog_entry_code'] ; ?>.html</guid>
<?php else : ?>
<guid isPermaLink="false">http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo $blog_entry['slug'] ; ?>.html</guid>
<?php endif; ?>
<description><![CDATA[<?php echo $blog_entry['seo_description'] ; ?>]]></description>
<content:encoded><![CDATA[<p><img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($blog_entry['blog_entry_code']); ?>" alt="<?php echo $blog_entry['title'] ; ?>" /></p><?php echo $blog_entry['contents'] ; ?>]]></content:encoded>
<wfw:commentRss></wfw:commentRss>
<slash:comments>0</slash:comments>
<?php if (empty($blog_entry['slug'])): ?>
<xhtml:link rel="alternate" media="handheld" type="text/html" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo $blog_entry['blog_entry_code'] ; ?>.html" />
<?php else : ?>
<xhtml:link rel="alternate" media="handheld" type="text/html" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo $blog_entry['slug'] ; ?>.html" />
<?php endif; ?>
</item>
<?php endforeach;?>
</channel>
</rss>
