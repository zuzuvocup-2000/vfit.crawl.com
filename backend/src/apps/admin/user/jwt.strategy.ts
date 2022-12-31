
import { ExtractJwt, Strategy } from 'passport-jwt';
import { PassportStrategy } from '@nestjs/passport';
import { Injectable } from '@nestjs/common';
import { JWT_CONSTANTS } from 'src/common/constants/app';

@Injectable()
export class JwtStrategy extends PassportStrategy(Strategy) {
  constructor() {
    super({
      jwtFromRequest: ExtractJwt.fromAuthHeaderAsBearerToken(),
      ignoreExpiration: false,
      secretOrKey: JWT_CONSTANTS.secret,
    });
  }

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  async validate(payload: any) {
    console.log(payload);
    return {
      userId: payload.sub,
      email: payload.email,
    };
  }
}
