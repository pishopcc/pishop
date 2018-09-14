<?php
// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-27 17:19:13
// +---------------------------------------------------------------------
namespace app\admin\logic;
use think\Model;
use think\Db;

/**
* 后台节点模型（供后台菜单使用）
*/
class Table extends Model
{
	protected $items;
	protected $total;
	public function getTableList()
	{
		$this->items = DB::query('SHOW TABLE STATUS');

		$this->total = count($this->items);

        foreach ($this->items as $k => &$v) {
            $v['size'] = pishop_format_bytes($v['Data_length'] + $v['Index_length']);
        }

        return $this;
	}
	/**
	 * [__call 魔术方法]
	 * @param  [type] $name [函数名]
	 * @return [type]       [description]
	 */
	public function __call($name,$data=array())
	{
		return $this->$name;
	}
}
