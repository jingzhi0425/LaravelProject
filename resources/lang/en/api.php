<?php

// api 接口返回 信息
// status => message
return [
    // 0 -> 500 System Error Code
    '0'                 => "Success",
    '401'               => 'Unauhorized',
    '403'               => '403 Forbidden',

    // 600 -> 699 OTP Controller
    '600'               => 'Successfully get the resource list',
    '664'               => 'OTP Function Not Open',
    '665'               => 'OTP MSG Error',
    '666'               => 'OTP Send Successfully',
    '667'               => 'OTP Resend Successfully',
    '668'               => 'Verification code failed.',
    '669'               => 'Verification code has expired.',
    '670'               => 'User does not exist',
    '671'               => 'Forget Password OTP Send Successfully',
    '672'               => 'PIN mismatch. Please try again',
    '673'               => 'PIN Record Not Found',
    '674'               => 'PIN match',

    // 700 -> 799 Users Controller
    '700'               => 'User Create Successfully',
    '701'               => 'User Not Found',
    '702'               => 'User Information Get Successfully',
    '703'               => 'Email or Password is Wrong',
    '704'               => 'User Information Update Successfully',
    '705'               => 'User New Password Update Successfully',
    '706'               => 'Old Passowrd Not Match',

    // 800 -> 899 Country Controller
    '801'               => 'Get All Active Country',

    // 900 -> 950 Product Category Controller
    '901'               => 'All Product Category Get Success',
    '902'               => 'Product Category Create Success',
    '903'               => 'Get Product Category Success',
    '904'               => 'Product Category Updated Success',
    '905'               => 'Product Category Delete Success',
    '906'               => 'Product Category Status Update Success',

    // 951 -> 999 Products Controller
    '951'               => 'All Products Get Success',
    '952'               => 'Product Create Success',
    '953'               => 'Get Product Success',
    '954'               => 'Product Updated Success',
    '955'               => 'Product Delete Success',
    '956'               => 'Product Status Update Success',
    '957'               => 'Duplicate product name appears.',

    // 1001 -> 1050 NoticeBoard Controller
    '1001'              => 'NoticeBoard Get Success',

    '1999'              => 'Document Update Successfully',
    '-1'                => "Something Error",
    'success'           => 'Function Success',
    'invalid_user'      => "Invalid User",
    'repeat_user'       => "Repeat User",
];
