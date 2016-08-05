<b>php端的输入验证，如果是POST过来的验证POST的变量，否则验证GET</b>
<code>$rules = array(
            'name' => array(
                'required',
                'maxlength'=>5
            ),
            'age' => array(
                'required',
                'int',
            ),
            'email' => array(
                'required',
                'email'
            )
        );
        $data = array(
            'name' => '',
            'age' => 'abc',
            'email' =>'123'
        );
        $msg = array(
            'name' => array(
                'required'=>'请填写用户名',
                'maxlength'=>'长度不能大于5'
            ),
            'age' => array(
                'required'=>'请填写年龄',
                'int'=>'年龄只能是整数',
            ),
            'email' => array(
                'required'=>'请填写email',
                'email'=>'邮箱格式错误'
            )
        );
        $parm=array('name','age','email');
        $data=Validator::GetData($parm);
        var_dump(Validator::ValidateInput($data, $rules, $msg));
	</code>
	GetData 用来获取用户的输入，有时我们在程序中会这样写代码：
	$userName=$_POST['userName'];
	$password=$_POST['password'];
	......
	一堆这样的代码，看起来很不美观。可以像下面这样写：
	 $parm=array('name','age','email');
     $data=Validator::GetData($parm);
	 extract($data);
	当然了，你也可以直接extract($_POST);区别是可能POST中有你不需要的数据。
<br/>
Validator::ValidateInput($data, $rules, $msg);
用来验证用户的输入是否正确，成功返回空'',失败反回错误信息，各字段的错误信息以<br/>分隔,用示与<a target='_blank' href='https://www.baidu.com/baidu?tn=monline_3_dg&ie=utf-8&wd=jquery+validate'>JQuery Validate</a>类似支持以下几种验证：<br/>

regex:正则表达式<br/>

ip：验证IP地址<br/>

numeric:数字，整数或小数<br/>
               
int:整数<br/>
                
url:网址<br/>

maxlength:最大长度限制<br/>

minlength:最小长度限制<br/>

max:最大值<br/>

min:最小值<br/>

email:邮箱<br/>