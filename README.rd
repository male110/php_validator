<b>php�˵�������֤�������POST��������֤POST�ı�����������֤GET</b>
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
                'required'=>'����д�û���',
                'maxlength'=>'���Ȳ��ܴ���5'
            ),
            'age' => array(
                'required'=>'����д����',
                'int'=>'����ֻ��������',
            ),
            'email' => array(
                'required'=>'����дemail',
                'email'=>'�����ʽ����'
            )
        );
        $parm=array('name','age','email');
        $data=Validator::GetData($parm);
        var_dump(Validator::ValidateInput($data, $rules, $msg));
	</code>
	GetData ������ȡ�û������룬��ʱ�����ڳ����л�����д���룺
	$userName=$_POST['userName'];
	$password=$_POST['password'];
	......
	һ�������Ĵ��룬�������ܲ����ۡ���������������д��
	 $parm=array('name','age','email');
     $data=Validator::GetData($parm);
	 extract($data);
	��Ȼ�ˣ���Ҳ����ֱ��extract($_POST);�����ǿ���POST�����㲻��Ҫ�����ݡ�
<br/>
Validator::ValidateInput($data, $rules, $msg);
������֤�û��������Ƿ���ȷ���ɹ����ؿ�'',ʧ�ܷ��ش�����Ϣ�����ֶεĴ�����Ϣ��<br/>�ָ�,��ʾ��<a target='_blank' href='https://www.baidu.com/baidu?tn=monline_3_dg&ie=utf-8&wd=jquery+validate'>JQuery Validate</a>����֧�����¼�����֤��<br/>

regex:������ʽ<br/>

ip����֤IP��ַ<br/>

numeric:���֣�������С��<br/>
               
int:����<br/>
                
url:��ַ<br/>

maxlength:��󳤶�����<br/>

minlength:��С��������<br/>

max:���ֵ<br/>

min:��Сֵ<br/>

email:����<br/>