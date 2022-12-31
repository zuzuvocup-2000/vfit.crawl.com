import { Injectable } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { HashService } from '../user/hash.service';
import { UserService } from '../user/user.service';

@Injectable()
export class AuthService {
  constructor(
    private userService: UserService,
    private hashService: HashService,
    private jwtService: JwtService,
  ) {}

  async validateUser(email: string, pass: string): Promise<unknown> {
    const user = await this.userService.getUserByEmail(email);
    if (user && (await this.hashService.comparePassword(pass, user.password))) {
      return user;
    }
    return null;
  }

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  async login(user: any) {
    const payload = {
      email: user.email,
      sub: user.id,
    };
    return {
      accessToken: this.jwtService.sign(payload),
    };
  }
}
