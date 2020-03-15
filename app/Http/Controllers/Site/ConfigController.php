<?php

namespace App\Http\Controllers\Site;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Http\Controllers\ApiController;
use App\Models\Site;
use App\Notifications\MailNotification;
use App\Services\SmsService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

/**
 * 站点配置
 * Class ConfigController
 * @package App\Http\Controllers\Site
 */
class ConfigController extends ApiController
{
  public function __construct()
  {
    $this->middleware('site:admin')->except('index');
  }

  public function show(Site $site)
  {
    $config = $site['config'] ?? [];
    foreach (config('hd.site') as $k => $v) {
      $config[$k] = array_merge($v, $config[$k]);
    }
    return $this->json($config);
  }

  public function update(Request $request, Site $site)
  {
    $site['config'] = $request->all();
    $site->save();
    return $this->json($site);
  }

  /**
   * 发送短信测试验证码
   * @param Request $request
   * @param SmsService $smsService
   * @return void
   * @throws ClientException
   * @throws ServerException
   */
  public function sms(Request $request, SmsService $smsService)
  {
    $smsService->code($request->phone);
    return $this->success('验证码发送成功');
  }

  /**
   * 发送测试邮件
   * @param Request $request
   * @param SmsService $smsService
   * @return JsonResponse
   * @throws ClientException
   * @throws ServerException
   */
  public function email(Request $request)
  {
    $user = auth()->user();
    $user['email'] = $request->email;
    $message = [
      'greeting' => 'Hi',
      'subject' => '测试邮件',
      'content' => '这是一封测试邮件',
      'salutation' => 'Copyright © 2010-2020 houdunren.com',
    ];
    Notification::send($user, new MailNotification($message));
    return $this->success('测试邮件发送发送成功');
  }
}
