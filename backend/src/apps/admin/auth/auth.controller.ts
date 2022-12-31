import { AuthService } from './auth.service';
import { Controller, Post, UnauthorizedException, Body } from '@nestjs/common';

@Controller('auth')
export class AuthController {
  constructor(private authService: AuthService) {}

  @Post(`/login`)
  async login(@Body() body) {
    const user = await this.authService.validateUser(body.email, body.password);
    if (!user) {
      throw new UnauthorizedException({
        message: 'You have entered a wrong email or password',
      });
    }
    return this.authService.login(user);
  }
}
