<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-07-30
 * Time: 20:47
 */

namespace Common\Common;


class Validator
{
    //获取用户传进来的数据，并验证数据是否正确,成功返回空''，失败返回错误信息
    public static function GetData($arrParamName)
    {
        $data = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST')//POST方式提交，获取POSt的数据，否则取GET数据
        {
            foreach ($arrParamName as $filed=> $var_name) {
                if(is_int($filed))
                    $data[$var_name] = $_POST[$var_name];
                else
                    $data[$var_name]=$_POST[$filed];
            }
        } else {
            foreach ($arrParamName as $filed=> $var_name) {
                if(is_int($filed))
                    $data[$var_name] = $_GET[$var_name];
                else
                    $data[$var_name]=$_GET[$filed];
            }
        }
       return $data;
    }
    //成功返回空，失败返回错误信息
    public static function ValidateInput($data, $rules, $errMsg)
    {
        $strErrMsg='';
        foreach ($rules as $key => $rule) {
            if (!is_array($rules)) {
                throw new \Exception($key . '配置错误');
            }
            //取规则的具体配置
            foreach ($rule as $ruleName => $ruleValue) {
                if (is_int($ruleName))
                {
                    $ruleKey = $ruleValue;
                    $ruleValue='';
                }
                else
                {
                    $ruleKey = $ruleName;
                }
                $ruleKey = trim(strtolower($ruleKey));
                $value='';
                if(isset($data[$key]))
                {
                    $value=$data[$key];
                }

                $msg=static::validate_field($key,$ruleKey, $ruleValue, $value);
               if($msg!=='')
               {
                   if(isset($errMsg[$key]))
                   {
                       $msg=$errMsg[$key][$ruleKey];
                   }
                   $strErrMsg.=$msg.'<br/>';
               }
            }
        }
        return $strErrMsg;
    }

    //成功返回空'',失败返回错误信息
    protected static function validate_field($key,$ruleName, $rule, $value)
    {
        switch ($ruleName) {
            case 'regex'://正则
                if (!empty($value) && !static::validate_reg($rule, $value)) {
                    return $key . '填写错误';
                }
                break;
            case 'ip':
                if (!empty($value) && !static::ip($value)) {
                    return $key . '不是一个有效的IP';
                }
                break;
            case 'required':
                if (!static::required($value)) {
                    return '请填写' . $key;
                }
                break;
            case 'numeric'://数字，整数或小数
                if (!empty($value) && !static::numeric($value)) {
                    return $key . '只能是数字';
                }
                break;
            case 'int'://整数
                if (!empty($value) && !static::integer($value)) {
                    return $key . '只能是整数';
                }
                break;
            case 'url':
                if (!empty($value) && !static::url($value)) {
                    return $key . '不是一个有效的url';
                }
                break;
            case 'maxlength':
                if (!empty($value) && !static::maxlength($value, $rule)) {
                    return $key . '的长度不能超过' . $rule;
                }
                break;
            case 'minlength':
                if (!empty($value) && !static::minlength($value, $rule)) {
                    return $key . '的长度不能小于' . $rule;
                }
                break;
            case 'max':
                if (!empty($value) && !static::max($value, $rule)) {
                    return $key . '不能大于' . $rule;
                }
                break;
            case 'min':
                if (!empty($value) && !static::min($value, $rule)) {
                    return $key . '不能小于' . $rule;
                }
                break;
            case 'email':
                if (!empty($value) && !static::email($value)) {
                    return $key . '邮件格式不正确';
                }
                break;
        }
        return '';//不支持的配置，直接忽略
    }
    //判断是否有效的email
    protected static function email($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    //验证正则表达式
    protected static function validate_reg($reg, $value)
    {
        if (!preg_match($reg, $value)) {
            return false;
        } else {
            return true;
        }
    }

    //验证ip地址
    protected static function ip($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP);
    }

    //必填项验证判断是否为空
    protected static function required($value)
    {
        return (!is_null($value) && (trim($value) != ''));
    }

    //判断是否为数字，整数或小数
    protected static function numeric($value)
    {
        return is_numeric($value);
    }

    //判断是否整数
    protected static function integer($value)
    {
        return is_int($value) || ($value == (string)(int)$value);
    }

    //验证是否url
    protected static function url($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

    //验证字符串的长度
    protected static function maxlength($value, $length)
    {
        return (strlen($value) <= $length);
    }

    //验证字符串的长度
    protected static function minlength($value, $length)
    {
        return (strlen($value) >= $length);
    }

    //验证最大值
    protected static function max($value, $max)
    {
        $value = $value + 0;
        $max = $max + 0;
        return $value <= $max;
    }

    //验证最小值
    protected static function min($value, $min)
    {
        $value = $value + 0;
        $min = $min + 0;
        return $value >= $min;
    }
}