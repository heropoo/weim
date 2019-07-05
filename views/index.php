<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?= asset('assets')?>/css/contacts.css">
    <script src="<?= asset('assets')?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<header>
    <span><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> <span>通讯录</span></span>
</header>
<section class="section">
    <div class="left_nav">
        <a class="open_window" data-url="<?= url('chat')?>"><li>
                <img src="http://www.qqzhi.com/uploadpic/2015-01-31/114503444.jpg" title="头像" alt="头像">
                <span>王彩彩</span>
            </li>
        </a>
    </div>
    <div class="right_nav select_contacts">

    </div>
</section>
<footer class="footer">
    <li>
        <a href="" class="open_window" data-url="./home.html">
            <i class="fa fa-commenting fa-lg" aria-hidden="true"></i>
            <span>消息</span>
        </a>
    </li>
    <li>
        <a href="" class="open_window" data-url="./contacts.html">
            <i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i>
            <span>联系人</span>
        </a>
    </li>
    <li>
        <a href="">
            <i class="fa fa-compass fa-lg" aria-hidden="true"></i>
            <span>更多</span>
        </a>
    </li>
</footer>
</body>
<script src="<?= asset('assets')?>/js/base.js"></script>
</html>