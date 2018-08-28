<?php

namespace wechat\build\message;

use wechat\build\Base;

/**
 * 消息管理
 * Class Message
 *
 * @package wechat\build
 */
class App extends Base
{
    use  Event, Basic, Send, SendAll;
}