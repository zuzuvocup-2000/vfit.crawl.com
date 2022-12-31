import { Module } from '@nestjs/common';
import { MongooseModule } from '@nestjs/mongoose';
import { HashService } from './hash.service';
import { User, UserSchema } from './schema/user.schema';
import { UserController } from './user.controller';
import { UserService } from './user.service';
import {
  JwtStrategy
} from './jwt.strategy';
import { AuthService } from '../auth/auth.service';
import { JwtModule } from '@nestjs/jwt';
import { JWT_CONSTANTS } from 'src/common/constants/app';

@Module({
  imports: [
    MongooseModule.forFeature([{ name: User.name, schema: UserSchema }]),
    JwtModule.register({
      secret: JWT_CONSTANTS.secret,
      signOptions: {
        expiresIn: '1d',
      },
    })
  ],
  controllers: [UserController],
  providers: [UserService, HashService, AuthService, JwtStrategy],
})
export class UserModule {}
