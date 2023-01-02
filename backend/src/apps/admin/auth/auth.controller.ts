import { AuthService } from './auth.service';
import { Controller, Post, Body } from '@nestjs/common';
import { CODES } from 'src/common/constants/code';

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
      }
    }

    return this.authService.login(user);
  }
}
