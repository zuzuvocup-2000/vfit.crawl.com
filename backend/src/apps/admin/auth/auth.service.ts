/* eslint-disable @typescript-eslint/no-explicit-any */
import { Injectable } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import { HashService } from '../user/hash.service';
import { User, UserDocument } from '../user/schema/user.schema';
import { UserService } from '../user/user.service';

@Injectable()
export class AuthService {
  constructor(
    private userService: UserService,
    private hashService: HashService,
    private jwtService: JwtService,
    @InjectModel(User.name) private userModel: Model<UserDocument>
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
      code: 200,
      email: user.email,
      name: user.name,
    };
  }

  async countUserByEmail(email:string): Promise<User> {
    return await this.userModel.findOne({
      email,
    }).exec();
  }

  async updateOtpUser(param: any): Promise<unknown> {
    return await this.userModel.updateOne(
      { email: param.email },
      param,
    );
  }

  async resetPassword(param: any): Promise<unknown> {
    const password = await this.hashService.hashPassword(
      param.password,
    );

    return await this.userModel.updateOne(
      { _id: param._id },
      { password },
    );
  }
}
