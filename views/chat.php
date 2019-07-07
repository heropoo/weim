<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>发送消息</title>
    <link rel="stylesheet" href="<?= asset('assets')?>/css/send_messages.css">
</head>
<body>
<header>
    <a class="open_window" data-url='./contacts.html'><i class="fa fa-angle-left" aria-hidden="true"></i></a> <span>🌺 木槿</span>
</header>
</body>
<section>
    <li class="left_messages">
        <p class="messages_content">
            <span>
                 你好呀
            </span>
        </p>
        <span class="min_icon"></span>
        <div class="header_img">
            <img src="<?= asset("assets/images/pkq.jpeg")?>" title="头像" alt="头像">
        </div>
    </li>
    <li class="right_messages">
        <div class="header_img">
            <img src="<?= asset("assets/images/mm1.jpeg")?>" title="头像" alt="头像">
        </div>
        <span class="min_icon"></span>
        <p class="messages_content">
            <span>
                你好呀！
            </span>
        </p>
    </li>
    
</section>
<footer class="footer">
    <div class="left_input">
        <input type="text" name="messages">
    </div>
    <div class="right_btn">
        <button>发送</button>
    </div>
</footer>
<script src="<?= asset('assets')?>/js/jquery-3.2.1.min.js"></script>
<script src="<?= asset('assets')?>/js/base.js"></script>
</html>