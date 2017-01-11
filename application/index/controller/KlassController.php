<?php
namespace app\index\controller;

use think\Request;
use app\common\model\Klass;

class KlassController extends IndexController
{
	/**
	 * index数据列表
	 * @return [type] [description]
	 */
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
		// $teachers = Teacher::all();
		// $this->assign('teachers', $teachers);
		
		//传入一个空的Klass，用以V层通过一对多关联的getTeacher()方法获取教师信息，而不必传入教师列表（Teacher）信息和use Teacher模型了。
		$Klass = new Klass;

		$Klass->id = 0;
		$Klass->name = '';
		$Klass->teacher_id = 0;

		$this->assign('Klass', $Klass);
		//调用edit.html模板
		return $this->fetch('edit');
	}

	/**
     * 对数据进行更新或保存
     * @说明：这里把function设置为private私有属性，一是为了更加安全，因为声明为private后，就不能通过URL来进行访问了；二是为了区别触发器与一般的函数，我们触发器是可以被URL来触发，而一般的函数只所以不叫做触发器，是由于通过URL触发不到。我们声明为private就达到了这个触发不到的目的。
     * @param  Klass &$Klass 注意：我们在这的参数为(&$Klass)，这使得：如果执行$Klass->validate(true)->save()时发生错误，错误信息能够能过Klass变量进行回传，这和C语言中的&a(将变量a的地址传入)是相同的道理。
     * @return [type]            [description]
     */
	private function saveKlass(Klass &$Klass)
	{
		$Request = Request::instance();
		$Klass->name = $Request->post('name');
		$Klass->teacher_id = $Request->post('teacher_id');

		return $Klass->validate(true)->save();
	}

	/**
	 * 插入新数据
	 * @return 成功返回插入数据的条数，失败返回false
	 */
	public function save()
	{
		$Klass = new Klass();

		if(!$this->saveKlass($Klass)){
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
        $Klass = Klass::get($id);

        if(is_null($Klass)){
        	return $this->error('所更新的记录不存在');
        }

        if(!$this->saveKlass($Klass)){
        	return $this->error('更新错误：' . $Klass->getError());
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
		$id = Request::instance()->param('id/d');

		// 获取当前对象
        $Klass = Klass::get($id);

        if(0 === $id || is_null($Klass)){
        	return $this->error('删除的记录不存在');
        }

        //删除对象
        if(!$Klass->delete()){
        	return $this->error('删除失败:' . $Klass->getError());
        }

        //删除班级课程信息(删除班级信息的同时要删除班级课程表中班级对应的信息)
        $map = ['klass_id' => $id];

        // 执行删除操作。由于可能存在 成功删除0条记录，故使用false来进行判断，而不能使用
        // if (!KlassCourse::where($map)->delete()) {
        // 我们认为，删除0条记录，也是成功
        if(false === $Klass->getKlassCourses()->where($map)->delete()){
        	return $this->error('删除班级课程关联信息发生错误' . $Klass->getKlassCourses()->getError());
        }

        // 进行跳转 
        return $this->success('删除成功', url('index'));
	}
}



