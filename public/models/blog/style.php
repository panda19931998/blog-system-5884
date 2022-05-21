<?php
$str = <<<EOT

/* -------------------------------------------
   基本
------------------------------------------- */
@media (min-width: 1200px) {
  .container {
    width: 1200px;
  }
}
h1, .h1,
h2, .h2,
h3, .h3,
h4, .h4,
h5, .h5,
h6, .h6 {
  margin-top: 0;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-weight: normal;
  color: #333;
}
body {
  background: #F7F7F7;
}
.container {
  padding-right: 0;
  padding-left: 0;
  background: #F7F7F7;
}

.page-title {
  font-size: 1.5em;
}

/* 追従ボタン */
#follow_btn {
  /* 文字色 */
  color: #fff;
  /* 文字サイズ */
  font-size: 20px;
  /* 背景色 */
  background-color: rgba(38, 194, 138, 1);
  /* 角丸枠線 */
  border-radius: 46px;
  /* 上下余白 */
  padding: 18px;
  /* 透明度 */
  opacity: 0.8;
  /* Aタグのアンダーラインを消す */
  text-decoration: none;
  /* 表示位置固定 */
  position: fixed;
  /* 表示位置（右） */
  right: 5px;
  /* 表示位置（下） */
  bottom: 20px;
  /* 初期は消す（JSで表示制御） */
  display:none;
}
/* 追従ボタン（ロールオーバー時） */
#follow_btn:hover {
  /* 背景色 */
  background-color: rgba(220,20,60,0.8);
}


/* -------------------------------------------
   モバイル対応
------------------------------------------- */
@media screen and (max-width: 768px) {
  .br-pc { display:none; }
  .pc-only { display:none; }
  .blog-header {
    padding: 10px 0 1px 20px;
  }
  .blog-header-img {
    padding: 0 0 0 0;
  }
  .blog-title {
    font-size: 25px;
  }
  .blog-header h1 {
    font-size: 25px;
  }
  .blog-description {
    font-size: 12px;
  }
  .blog-sidebar {
    width: 100%;
  }
  .blog-post {
    padding-left: 10px;
    padding-right: 10px;
  }
  .container{
   overflow:hidden;
  }
  .sidebar-module-title h4 {
    padding-left: 5px;
  }
  .sidebar_category_padding {
    padding-left: 5px;
    float: left;
  }
  .blog-list-entry-title {
    font-size: 20px;
    font-weight: bold;
    line-height: 1.5em;
    text-align: center;
    margin-top: 10px;
    padding: 0 40px 0 40px;
  }
  .blog-list-entry-title a {
    color: #373737;
  }
  .description {
    font-size: 15px;
    margin-top: 30px;
    padding: 0px 20px 0 20px;
    text-align:center;
    line-height:2em;
  }
  .blog-post-title {
    margin: 0 0 0 0;
    font-size: 20px;
    line-height: 30px;
    padding-bottom: 10px;
  }
  .blog-post-author-comment {
    position: relative;
    float: left;
    width: 80%;
  }
  .blog-post-author-image {
    float: left;
    width: 20%;
    padding-left: 20px;
  }
  .blog-post-introduction {
    position: relative;
    float: left;
    width: 80%;
  }
  .blog-post-index {
    font-size: 1em;
  }

  .blog-post-entry-link-eyecatch {
    float: left;
    width: 30%;
    /*margin: 10px;*/
  }
  .blog-post-entry-link-contents {
    margin: 12px 0 0 10px;
    float: left;
    width: 60%;
    font-size: 0.8em;
    font-weight: bold;
    line-height: 1.2em;
  }
  .blog-post-facebook-area-contents {
    float: left;
    width: 50%;
    font-size: 1em;
    font-weight: bold;
    color: #fff;
    text-align: center;
    margin-top: 5px;
    padding-left: 5px;
  }
  .blog-post-facebook-area-contents p {
    text-align: center;
    margin: 10px 0 0 0;
    font-size: 0.8em;
    line-height: 1em;
  }
  .entry-pager {
    margin: 30px 0 50px 0;
    width: 100%;
    font-size: 0.9em;
  }
  .relation-entry {
    font-size: 0.9em;
    margin:30px 0 20px 0;
    padding-bottom: 5px;
    border-bottom: 1px solid #e5e5e5;
    display:block;
  }
  .blog-entry-relation-area {
    font-size: 18px;
    margin-top: 20px;
    margin-bottom: 10px;
  }
  .sidebar-category-name {
    font-size: 14px;
    line-height: 2em;
  }
  .blog-footer-left {
    font-size: 0.9em;
  }
  .blog-footer-right {
    font-size: 0.9em;
  }
  .blog-list-entry-eyecatch {
    padding: 0 0 0 0;
    margin-top: 20px;
    width: 100%;
    height: 150px;
  }
  .nav>li {
    text-align:center;
    border-right: 1px solid #e5e5e5;
  }
  .lead01 {
    line-height: 35px;
  }
  .blog-post-entry-list-area {
    font-size: 1em !important;
  }
  .note-video-clip {
    width: 100%;
    height: 200px;
  }
  #list-more-area {
    text-align: center;
    margin:20px 0 10px 0;
  }
  .blog-list-entry-posting-date-area {
    margin-top:0px;
  }
  .page-title-area {
    margin-left: 15px;
    margin-top: 15px;
  }
  .blog-post-posting-date {
    color: #696969;
    font-size: 12px;
    margin-top: 10px;
    text-align: center;
  }
  .sidebar-twitter {
    width: 90%;
    margin: 0px auto;
  }
}
@media screen and (min-width: 768px) {
  .br-sp { display:none; }
  .sp-only { display:none; }
  .blog-header {
    padding: 50px 60px;
  }
  .blog-header-img {
    padding: 0 0 0 0;
  }
  .blog-title {
    font-size: 60px;
  }
  .blog-header h1 {
    font-size: 60px;
  }
  .blog-description {
    font-size: 20px;
  }
  .blog-sidebar {
  }
  .blog-post {
    padding: 0 20px 0 20px;
  }
  .blog-list-entry-title {
    font-size: 2em;
    font-weight: bold;
    line-height: 1.5em;
    text-align: center;
    margin-top: 30px;
    padding: 0 40px 0 40px;
  }
  .blog-list-entry-title a {
    color: #373737;
  }
  .description {
    font-size: 18px;
    margin-top: 30px;
    padding: 0px 20px 0 20px;
    text-align:center;
    line-height:2em;
  }
  #list-more-area {
    text-align: center;
    margin:40px 0 30px 0;
  }
  .blog-post-title {
    margin: 20px 0 0 0;
    font-size: 33px;
    line-height:50px;
    padding-bottom: 10px;
  }
  .blog-post-author-comment {
    position: relative;
    float: left;
    width: 90%;
  }
  .blog-post-author-image {
    float: left;
    width: 10%;
    padding-left: 20px;
  }
  .blog-post-introduction {
    position: relative;
    float: left;
    width: 90%;
  }
  .blog-post-index {
    font-size: 1em;
  }
  .blog-post-entry-link-eyecatch {
    float: left;
    width: 20%;
    /*margin: 10px;*/
  }
  .blog-post-entry-link-contents {
    margin: 22px 0 0 10px;
    float: left;
    width: 75%;
    /*
    font-size: 1em;
    font-weight: bold;
    line-height: 1.2em;
    */
  }
  .blog-post-facebook-area-contents {
    float: left;
    width: 50%;
    font-size: 1em;
    font-weight: bold;
    color: #fff;
    text-align: center;
    margin-top: 3em;
  }
  .blog-post-facebook-area-contents p {
    text-align: center;
    margin-top: 1em;
  }
  .entry-pager {
    margin: 30px 0 50px 0;
    width: 100%;
  }
  .relation-entry {
    font-size: 1.2em;
    margin:30px 0 20px 0;
    padding-bottom: 5px;
    border-bottom: 1px solid #e5e5e5;
    display:block;
  }
  .blog-entry-relation-area {
    margin-top: 20px;
  }
  .sidebar-category-name {
    font-size: 14px;
    line-height: 2em;
  }
  .blog-footer-left {
    font-size: 0.9em;
    float:left;
    margin-left:20px;
  }
  .blog-footer-right {
    font-size: 0.9em;
    float:right;
    margin-right:20px;
  }
  /* サイドバー追従広告（PCのみ） */
  .fix-ad-area-fixed {
    top: 1%;
    position: fixed;
  }
  .blog-list-entry-eyecatch {
    padding: 0 0 0 0;
    margin-top: 40px;
    width: 100%;
    height: 300px;
  }
  .nav>li {
    display: table-cell;
    text-align:center;
    border-right: 1px solid #e5e5e5;
  }
  .blog-list-entry-posting-date-area {
    margin-top:20px;
  }
  .page-title-area {
    margin-left: 15px;
  }
  .blog-post-posting-date {
    color: #696969;
    font-size: 12px;
    margin-top: 30px;
    text-align: center;
  }
  /* この記事を書いた人エリア */
  .tb-left, .tb-right {
    display: table-cell;
    vertical-align: middle;
  }

  .blog-post-author-area .tb-left {
    width: 220px;
    border-right: 1px #eaedf2 dashed;
    text-align: center;
  }

  .blog-post-author-area .tb-right {
    width: calc(100% - 220px);
  }
}

/* -------------------------------------------
   ブログヘッダー
------------------------------------------- */
.blog-header {
  margin: 0 0 20px 0;
  background: #F5F5F5;
}
.blog-header a {
  color: #555555;
}
.blog-header a:link, .blog-header a:hover, .blog-header a:active, .blog-header a:visited {
  text-decoration: none;
}
.blog-title {
  margin-top: 30px;
  margin-bottom: 0;
  font-weight: normal;
}
.blog-header h1 {
  margin-top: 9px;
  margin-bottom: 10px;
}
.blog-description {
  color: #999;
}

/* -------------------------------------------
   ヘッダーナビ
------------------------------------------- */
.navbar {
  border-radius: 0;
}
.navbar-collapse {
  padding: 0;
}
.navbar .container-fluid {
  padding: 0;
}

.nav {
display:table; /* テーブル要素として表示 */
width:100%;/* 任意の横幅 */;
}

.navbar-nav>li {
  float:none;
}


.navbar-default {
  border: none;
  border-bottom: 1px solid #e5e5e5;
}

/* -------------------------------------------
   パンくずリスト
------------------------------------------- */
.breadcrumb {
  background: #f8f8f8;
  border-radius: 0px;
  margin: 0 10px 20px 15px;
}

/* -------------------------------------------
   ブログ記事
------------------------------------------- */
.blog-post {
  margin-bottom: 60px;
  font-size: 1.2em;
  line-height: 2em
}

.blog-post h2 {
  margin: 0 0 0 0;
  color: #000000;
  font-size: 1.3em;
  padding: 30px 15px 30px 15px;
  border-left: 8px solid #1bb4d3;
  background-color: #F7F7F7;
}

.blog-post h3 {
  /*
  border-left: 4px solid #1bb4d3;
  padding: 15px 0 15px 15px;
  margin: 30px 0 0 0 ;
  font-size: 1.3em;
  font-weight: bold;
  */

  border-bottom: 2px solid #1bb4d3;
  padding: 0 0 10px 0;
  margin: 0 0 0 0 ;
  font-size: 1.2em;
}

.blog-post-author-comment-area {
  width: 100%;
}


.blog-post-author-comment:before {
  content: '';
  position: absolute;
  display: block;
  width: 0;
  height: 0;
  right: -10px;
  top: 20px;
  border-left: 10px solid #E3EFD8;
  border-top: 10px solid transparent;

  border-bottom: 10px solid transparent;
}

.blog-post-author-image>img {
  width: 60px;
  border: 1px solid #e5e5e5;
}

.blog-post-introduction-area {
  width: 100%;
}
.blog-post-introduction.alert-success {
  background-color: #fff;
  color: #000;
  margin: 0;
}

.blog-post-introduction:before {
  content: '';
  position: absolute;
  display: block;
  width: 0;
  height: 0;
  right: -10px;
  top: 20px;
  border-left: 10px solid #E3EFD8;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
}

.blog-post-introduction:after {
  content: '';
  position: absolute;
  display: block;
  width: 0;
  height: 0;
  right: -8px;
  top: 22px;
  border-left: 8px solid #fff;
  border-top: 8px solid transparent;
  border-bottom: 8px solid transparent;
}

/* 別記事埋め込み */
.blog-post-entry-link-area {
  border: 1px solid #e5e5e5;
  overflow: hidden;
  margin: 0;
  position: relative;
}
.blog-post-entry-link-area p {
  background: #000;
  width: 55px;
  font-size: 12px;
  color: #fff;
  padding-left: 4px;
  position: absolute;
  /*
  top: 10px;
  left: 10px;
  */
}

.blog-post-entry-link-contents a:link, .blog-post-entry-link-contents a:hover, .blog-post-entry-link-contents a:active, .blog-post-entry-link-contents a:visited {
  color: #000;
}
.blog-post-entry-link-postingdate {
  margin-top: 5px;
  font-size: 0.7em;
}
.blog-post-entry-link-description {
  margin-top: 10px;
  font-size: 0.8em;
}

.link-eyecatch-none {
  width: 100%;
  height: 100px;
  background: #dcdcdc;
}

/* コード */
.blog-post-code-area pre {
  /*display: none;*/
  background-color: #364549;
  color: #e3e3e3;
  /*margin-left: -20px;*/
  /*margin-right: -20px;*/
  border-radius: 0;
  border: 0;
  padding: 0 0 20px 5px;
  margin: 0;
  font-size: 15px;
}

.blog-post-code-area pre code {
}

/* リスト表示（青） */
.blog-post-entry-list-area {
  list-style: none;
  padding: 20px;
  line-height: 2.2em;
  background: #eff8ff;
  outline: 1px solid #e5e5e5;
  border-color: #e5e5e5;
}

/* リスト表示（グレー） */
.blog-post-entry-list-area-gray {
  list-style: none;
  padding: 20px;
  line-height: 2.2em;
  background: #fafafa;
  outline: 1px solid #f0f0f0;
  border-color: #f0f0f0;
}

/* リスト表示（外部リンク） */
.blog-post-entry-list-area-ex-link {
  list-style: none;
  padding: 10px;
  padding-inline-start: 20px;
  line-height: 2.2em;
  background: #fafafa;
  outline: 1px solid #f0f0f0;
  border-color: #f0f0f0;
}

/* 目次 */
.blog-post-index {
  border: 1px solid #e5e5e5;
  background: #eff8ff;
  margin: 0 0 30px 0;
  padding: 20px 20px 20px 20px;
  line-height: 2.2em;
}
.blog-post-index .index-title {
  text-align: left;
  padding: 0;
  font-size: 1em;
  font-weight: normal;
}
.index-title {
  text-align: center;
  padding: 0;
  font-size: 1.1em;
  font-weight: normal;
}
.blog-post-index ul {
  padding: 0 0 0 0;
}

.blog-post-index li.index-title {
  list-style: none;
}
.blog-post-index li.index-item {
  margin-left: 30px;
}

.blog-post-index li {
  margin-left: 10px;
  color: #1bb4d3;
}
.blog-post-index li>a {
  color: #1bb4d3;
}
.blog-post-index li>a:hover {
  text-decoration: underline;
}

/* Youtube */
.youtube iframe {
  border: 0;
  width: 100%;
}

/* Facebookエリア */
.blog-post-facebook-area {
  overflow: hidden;
  position: relative;
  border: 1px solid #e5e5e5;
  width: 100%;
  background: #000;
}
.blog-post-facebook-area-eyecatch {
  float: left;
  width: 50%;
}

.facebook-eyecatch-none {
  width: 100%;
  height: 100px;
  background: #000;
}

/* 記事下メルマガ誘導バナー */
.blog-entry-bottom-banner-area {
  margin: 40px 0 0 0;
}

.blog-entry-bottom-banner-area:hover {
  filter:alpha(opacity=80);
  opacity:0.8;
  text-decoration: none;
}

/* 関連記事 */
.relation-posting-date {
  font-size: 10px;
  margin: 0;
  padding: 0;
  height: 20px;
}

.relation-entry-title {
  font-size: 0.8em;
  line-height: 20px;
  margin: 5px 0 0 0;
  padding: 0;
  font-weight: bold;
}
.relation-eyecatch-none {
  width: 100%;
  height: 100px;
  background: #dcdcdc;
}

/* 前／次の記事ページャー */
.entry-pager-next {
  text-align: left;
  margin-bottom: 20px;
}
.entry-pager-previous {
  text-align: right;
}

/* 記事上部LPバナー（モバイルのみ） */
.blog-post-banner-area {
  text-align: center;
  margin-top: 30px;
}
.blog-post-banner-area .img-responsive {
  display: inline;
}

/* 記事下部CTAエリア */
.blog-post-bottom-cta-area {
  margin-top: 20px;
}

.shortcode-alert {
  margin-top: 20px;
}

/* a:hoverの設定 */
.blog-post a:link, .blog-post a:hover, .blog-post a:active, .blog-post a:visited {
  text-decoration: none;
}
.entry-pager a:hover {
  text-decoration: underline;
}
.blog-post-entry-link:hover {
  filter:alpha(opacity=80);
  opacity:0.8;
  background: #f0f8ff;
  text-decoration: none;
}
.blog-entry-relation-area:hover {
  filter:alpha(opacity=80);
  opacity:0.8;
  text-decoration: none;
}

.blog-post-meta-left {
  margin-bottom: 20px;
  color: #696969;
  font-size: 14px;
  float: left;
}
.blog-post-meta-right {
  margin-bottom: 20px;
  color: #696969;
  font-size: 14px;
  float: right;
}
.blog-post img {
  // width: 600px;
  display: block;
  height: auto;
  max-width: 100%;
}
.blog-post-ad-area {
  margin-top: 40px;
  width: 100%;
}
.blog-category-label {
  font-size: 13px;
}

/* この記事を書いた人エリア */
.blog-post-author-area {
  margin-bottom: 10px;
}

.blog-post-author-area .tb-left {
  padding: 20px 15px 5px;
  text-align: center;
}

.blog-post-author-area .tb-right {
  padding: 20px;
  font-size: 0.95em;
  line-height: 1.7;
}

.blog-post-author-area .author_label span {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    background: #eaedf2;
    color: #555;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* -------------------------------------------
   ソーシャルボタン
------------------------------------------- */
.sns-button-area {
  margin-top: 20px;
}
.sns-button {
  display: block;
  padding: 6px 12px;
  color: #fff;
  font-size: 14px;
  text-align: center;
  border-radius: 4px;
}
.sns-button:hover {
  color: #fff;
  text-decoration: none;
  filter:alpha(opacity=80);
  opacity:0.8;
}
.sns-button.sns-twitter {
  background-color: #55AACE;
}
.sns-button.sns-facebook {
  background-color: #3B5998;
}
.sns-button.sns-line {
  background-color: #00c300;
}
.sns-button.sns-google {
  background-color: #dd4b39;
}
.sns-button.sns-hatena {
  background-color: #008fde;
}
.sns-button.sns-feedly {
  background-color: #6cc655;
}

/* -------------------------------------------
   ブログ記事リスト
------------------------------------------- */
.blog-list {
  margin-bottom: 10px;
}

.blog-list-entry-area {
  background-color: #fff;
  padding: 10px 0 20px 0;
  margin: 0 0 20px 0;
  overflow:hidden;
  clear: both;
}

.blog-list-entry-content {
  margin: 0;
}

.blog-list-entry-content a:hover {
  text-decoration: none;
}

.blog-list-entry-posting_date {
  font-size: 12px;
  color: #696969;
}

.blog-list-category-area {
  margin: 0 0 15px 0;
  padding: 0 0 0 0;
}

.blog-list-category-name {
  margin: 0 10px 0 0;
  font-size: 12px;
}

.blog-list-pager-area {
  margin: 0 0 0 15px;
  border-top: 1px dotted #e5e5e5;
  text-align: center;
  clear: both;
}


/* -------------------------------------------
   ページャー
------------------------------------------- */
.pager {
  margin: 0 0 30px 10px;
  text-align: center;
}
.pager > li > a {
  padding: 10px 20px;
  text-align: center;
  font-size: 0.8em;
}

/* -------------------------------------------
   サイドバー
------------------------------------------- */
.sidebar-module {
  margin: 0 0 20px 0;
}
.sidebar-module .panel-heading h2 {
  font-size: 15px;
}
.sidebar-lp-banner {
  text-align: center;
}
.sidebar-lp-banner:hover {
  filter:alpha(opacity=80);
  opacity:0.8;
  text-decoration: none;
}

.sidebar-module .img-responsive {
  display: inline;
}
.sidebar-category-list {
  margin: 0;
  padding: 0 0 0 0;
  list-style-type: none;
  margin-left:14px;/* マーカーを1文字寄せた分、ULにマージンを設定*/
}
.sidebar-category-list li:before {
  content: '>'; /* ←ここにリストマーカーにしたい文字列を設定 */
  margin-left:-14px; /* 1文字分、左に寄せる */
}
.sidebar-category-name a:link, .sidebar-category-name a:hover, .sidebar-category-name a:active, .sidebar-category-name a:visited {
    color: #000;
}


.sidebar-profile-image {
  text-align: center;
}

.sidebar-profile {
  margin-top: 15px;
  white-space: pre-line;
}

.sidebar-list {
  min-height: 30px;
  list-style: none;
  overflow: hidden;
  clear:both;
  padding: 0 0 10px 0;
  border-bottom: 1px dotted #e5e5e5;
}
.sidebar-list:hover {
  filter:alpha(opacity=80);
  opacity:0.8;
}

.sidebar-list-left {
  float: left;
  width: 30%;
  position: relative;
}

.sidebar-list-left p {
  position: absolute;
  color: white;
  top: 0;
  left: 0;
  background: #1bb4d3;
  color: #ffffff;
  padding: 1px 6px;
}

.sidebar-list-right {
  float: left;
  width: 65%;
  margin: 0 0 0 5px;
}
.sidebar-list-right a:hover {
  text-decoration: none;
}
.sidebar-popular-list-entry-title {
  font-size: 14px;
}

.sidebar-popular-list-entry-views {
  font-size: 11px;
}

.sidebar-popular-list-entry-eyecatch {
}

.sidebar-popular-list-entry-eyecatch>img {
  width: 80px;
  height: 80px;
  object-fit: cover;
}

.sidebar-popular-list-entry-eyecatch-none {
  width: 80px;
  height: 80px;
  background: #dcdcdc;
}

/* -------------------------------------------
   フッター
------------------------------------------- */
.blog-footer {
  padding: 20px 0 10px 0;
  background-color: #f9f9f9;
  text-align: center;
  color: #999;
  border-top: 1px solid #e5e5e5;
}

/* -------------------------------------------
   エラーページ
------------------------------------------- */
.error-page .jumbotron {
  margin: 80px 100px;
}
.error-page .jumbotron p {
  font-size: 15px;
}
.error-page-button {
  margin-top: 50px;
}
.error-page-button a:link, .error-page-button a:hover, .error-page-button a:active, .error-page-button a:visited {
    color: #fff;
}


/* -------------------------------------------
   ページネーション
------------------------------------------- */
a:link {text-decoration:none }
a.page_number:visited {color: black; text-decoration:none }
.pagination {
  display: flex;
  justify-content: center;
  margin: 15px;
}

.pagination2 {
  display: flex;
  justify-content: center;
  margin: 15px;
}
.page_feed {
  width: 30px;
  margin: 0 10px;
  padding: 5px 10px;
  text-align: center;
  background: #b8b8b8;
  color: black;
}
.first_last_page {
  width: 30px;
  margin: 0 10px;
  padding: 5px 10px;
  text-align: center;
  background: #f0f0f0;
  color: black;
}

a:link {text-decoration:none }
a.page_number:visited {color: black; text-decoration:none }
.page_number {
  width: 30px;
  margin: 0 10px;
  padding: 5px;
  text-align: center;
  background: #b8b8b8;
  color: black;
}
.now_page_number {
  width: 30px;
  margin: 0 10px;
  padding: 5px;
  text-align: center;
  background: #f0f0f0;
  color: black;
  font-weight: bold;
}

EOT;

header('Content-type: text/css');
echo $str;
