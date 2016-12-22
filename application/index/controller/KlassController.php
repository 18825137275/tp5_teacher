<?php
namespace app\index\controller;

use think\Request;
use app\common\model\Klass;
use app\common\model\Teacher;

class KlassController extends IndexController
{
	public function index()
	{
		// 获取查询信息
		$name = Request::instance()->get('name');

		$pageSize = 5;//每月显示条数
		
		$Klass = new Klass();
		$klasses = $Klass->pagiN($pageSize, $name);

		$this->assign('klasses', $klasses);

		return $this->fetch();
	}

	/**
	 * 增加数据页面
	 */
	public function add()
	{
		//获取所有的教师信息
		$teachers = Teacher::all();
		$this->assign('teachers', $teachers);
		return $this->fetch();
	}

	/**
	 * 插入新数据
	 * @return 成功返回插入数据的条数，失败返回false
	 */
	public function save()
	{
		// 实例化请求信息
		$Request = Request::instance();

		// 实例化班级并赋值
		$Klass = new Klass();
		$Klass->name = $Request->post('name');
		$Klass->teacher_id = $Request->post('teacher_id');
		// $status = $Klass->validate(true)->save();

		if(!$Klass->validate(true)->save()){
			return $this->error('数据添加错误：'.$Klass->getError());
		}

		return $this->success('添加成功！', url('index'));
	}

	/**
	 * 编辑数据
	 * @return [type] [description]
	 */
	public function edit()
	{
		$id = Request::instance()->param('id/d');

		//获取所有的教师信息(此步骤用getTeacher方法代替)
		// $teachers = Teacher::all();
		// $this->assign('teachers', $teachers);

		//获取用户操作的班级信息
		if(false === ($Klass = Klass::get($id))){
			return $this->error('未找到此记录');
		}

		$this->assign('Klass', $Klass);
		return $this->fetch();
	}

	/**
	 * 更新数据
	 * @return [type] [description]
	 */
	public function update()
	{
		// 接收数据，取要更新的关键字信息
		$id = Request::instance()->post('id/d');

		// 获取当前对象
        $klass = Klass::get($id);

        if(is_null($klass)){
        	return $this->error('所更新的记录不存在');
        }

        //数据更新
        $klass->name = Request::instance()->post('name');
        $klass->teacher_id = Request::instance()->post('teacher_id');
        if(!$klass->validate(true)->save()){
        	return $this->error('更新错误：' . $klass->getError());
        }else{
        	return $this->success('操作成功', url('index'));
        }
	}

	/**
	 * 删除数据
	 * @return [type] [description]
	 */
	public function delete()
	{
		// 接收数据，取要删除的关键字信息
		$Request = Request::instance();
		$id = $Request->param('id/d');

		// 获取当前对象
        $klass = Klass::get($id);

        if(0 === $id || is_null($klass)){
        	return $this->error('删除的记录不存在');
        }

        //删除对象
        if(!$klass->delete()){
        	return $this->error('删除失败:' . $klass->getError());
        }

        // 进行跳转 
        return $this->success('删除成功', $Request->header('referer')); 
	}
}



