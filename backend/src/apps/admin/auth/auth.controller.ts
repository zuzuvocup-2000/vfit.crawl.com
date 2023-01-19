import { AuthService } from './auth.service';
import { Controller, Post, Body } from '@nestjs/common';
import { CODES } from 'src/common/constants/code';
import { sendOtpRequest } from './dto/send-otp.requests';

@Controller('auth')
export class AuthController {
  constructor(private authService: AuthService) {}

  @Post(`/login`)
  async login(@Body() body) {
    const user = await this.authService.validateUser(body.email, body.password);
    if (!user) {
      return {
        'message': 'Tài khoản hoặc mật khẩu không chính xác!',
        'code': CODES.UNAUTHENTICATED
      };
    }

    return this.authService.login(user);
  }

  @Post(`/count`)
  async count(@Body() body) {
    const user = await this.authService.countUserByEmail(body.email);
    if (!user) return { 'code': CODES.BAD_REQUEST };
    return {
      'code': CODES.SUCCESS,
      'data': user
    };
  }

  @Post(`/send-otp`)
  async sendOtp(@Body() sendOtpRequest: sendOtpRequest) {
    await this.authService.updateOtpUser(sendOtpRequest);
    return true;
  }

  @Post(`/reset-password`)
  async resetPassword(@Body() body) {
    return await this.authService.resetPassword(body);
  }
}
