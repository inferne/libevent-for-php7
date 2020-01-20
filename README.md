libevent扩展升级php7.2版本（理论上7以上版本皆可运行），有些地方可能测试不足，用于生产环境前，请做足够的测试。

查看文档请移步官方文档：https://www.php.net/manual/zh/book.libevent.php

欢迎反馈bug

ps：经过半年多的运行，发现在释放连接时有轻微的内存泄露，使用的话请做好相关措施。比如用来开发server，则需要定期重启
