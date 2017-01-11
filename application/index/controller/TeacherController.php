<?php
namespace app\index\controller; // 该文件的位于application\index\controller文件夹

use app\common\model\Teacher; // 引用Request
use think\Request;
// 教师模型

/**
 * 教师管理，继承think\Controller后，就可以利用V层对数据进行打包了。
 */
class TeacherController extends IndexController
{
    /**
     * index数据列表
     * @return [type] [description]
     */
    public function index()
    {
        // 获取查询信息
        $name = Request::instance()->get('name');

        $pageSize = 5; // 每页显示5条数据

        // 实例化Teacher
        $Teacher = new Teacher;

        $teachers = $Teacher->pagiN($pageSize, $name);

        // 向V层传数据
        $this->assign('teachers', $teachers);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }

    /**
     * 新增数据交互
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-07T12:41:23+0800
     */
    public function add()
    {
        //重构代码，传入一个空的模型，跟edit共用一个模板edit.html
        //实例化
        $Teacher = new Teacher();

        //设置默认值
        $Teacher->id       = 0;
        $Teacher->name     = '';
        $Teacher->username = '';
        $Teacher->sex      = 0;
        $Teacher->email    = '';

        $this->assign('Teacher', $Teacher);
        //调用edit.html模板
        return $this->fetch('edit');
    }

    /**
     * 对数据进行更新或保存
     * @说明：这里把function设置为private私有属性，一是为了更加安全，因为声明为private后，就不能通过URL来进行访问了；二是为了区别触发器与一般的函数，我们触发器是可以被URL来触发，而一般的函数只所以不叫做触发器，是由于通过URL触发不到。我们声明为private就达到了这个触发不到的目的。
     * @param  Teacher &$Teacher 注意：我们在这的参数为(&$Teacher)，这使得：如果执行$Teacher->validate(true)->save()时发生错误，错误信息能够能过Teacher变量进行回传，这和C语言中的&a(将变量a的地址传入)是相同的道理。
     * @param  boolean $isUpdate 判断是否为更新操作，如果是更新某些不能修改的数据则不被提交
     * @return [type]            [description]
     */
    private function saveTeacher(Teacher &$Teacher, $isUpdate = false)
    {
        // 写入要更新的数据
        $Teacher->name = input('post.name');
        //如果为更新操作，用户名不能修改
        if (!$isUpdate) {
            $Teacher->username = input('post.username');
        }
        $Teacher->sex   = input('post.sex');
        $Teacher->email = input('post.email');

        // 更新或保存
        return $Teacher->validate(true)->save();
    }

    /**
     * 插入新数据
     * @return   html
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-07T12:31:24+0800
     */
    public function save()
    {
        // 实例化Teacher空对象
        $Teacher = new Teacher();

        // 反馈结果
        if (false === $this->saveTeacher($Teacher)) {
            // 验证未通过，发生错误
            return '新增失败:' . $Teacher->getError();
        }

        // 提示操作成功，并跳转至教师管理列表
        return $this->success('操作成功！', url('index'));
    }

    /**
     * 编辑
     * @return   html
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-07T13:52:29+0800
     */
    public function edit()
    {
        // 获取传入ID
        $id = Request::instance()->param('id/d');

        // 在Teacher表模型中获取当前记录
        if (null === ($Teacher = Teacher::get($id))) {
            // 由于在$this->error抛出了异常，所以也可以省略return(不推荐)
            $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 将数据传给V层
        $this->assign('Teacher', $Teacher);

        // 获取封装好的V层内容,返回给用户
        return $this->fetch();
    }

    /**
     * 更新
     * @return
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-07T14:03:41+0800
     */
    public function update()
    {
        // 接收数据，取要更新的关键字信息
        $id = Request::instance()->post('id/d');

        // 获取当前对象
        $Teacher = Teacher::get($id);

        if (is_null($Teacher)) {
            return $this->error("所更新的记录不存在");
        }

        // 更新
        if (false === $this->saveTeacher($Teacher, true)) {
            return $this->error('更新失败' . $Teacher->getError());
        }

        // 成功跳转至index触发器
        return $this->success('操作成功', url('index'));
    }

    /**
     * 删除
     * @return   跳转
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-07T13:52:07+0800
     */
    public function delete()
    {
        // 实例化请求类
        $Request = Request::instance();

        // 获取get数据
        $id = Request::instance()->param('id/d');

        // 判断是否成功接收
        if (0 === $id) {
            return $this->error('未获取到ID信息');
        }

        // 获取要删除的对象
        $Teacher = Teacher::get($id);

        // 要删除的对象不存在
        if (is_null($Teacher)) {
            return $this->error('不存在id为' . $id . '的教师，删除失败');
        }

        // 删除对象
        if (!$Teacher->delete()) {
            return $this->error('删除失败:' . $Teacher->getError());
        }

        // 进行跳转
        return $this->success('删除成功', $Request->header('referer'));
    }
}
