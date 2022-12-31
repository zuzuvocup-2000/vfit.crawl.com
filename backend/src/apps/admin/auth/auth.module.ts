import { Module } from '@nestjs/common';
import { AuthService } from './auth.service';
import { AuthController } from './auth.controller';
import { MongooseModule } from '@nestjs/mongoose';
import { JwtModule } from '@nestjs/jwt';
import { JWT_CONSTANTS } from 'src/common/constants/app';
import { User, UserSchema } from '../user/schema/user.schema';
import { UserService } from '../user/user.service';
import { HashService } from '../user/hash.service';

@Module({
  imports: [
    MongooseModule.forFeature([
      {
        name: User.name,
        schema: UserSchema,
      },
    ]),
    JwtModule.register({
      secret: JWT_CONSTANTS.secret,
      signOptions: {
        expiresIn: '1d',
      },
    }),
  ],
  controllers: [AuthController],
  providers: [AuthService, UserService, HashService],
})
export class AuthModule {}
