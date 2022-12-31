import {
  BadRequestException,
  Injectable,
} from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import { User, UserDocument } from './schema/user.schema';
import { CreateUserRequest } from './dto/create-user.request';
import { HashService } from './hash.service';

@Injectable()
export class UserService {
  constructor(
    @InjectModel(User.name) private userModel: Model<UserDocument>,
    private hashService: HashService,
  ) {}

  async create(createUserRequest: CreateUserRequest) {
    // validate DTO
    const createUser = new this.userModel(createUserRequest);
    // check if user exists
    const user = await this.getUserByEmail(createUser.email);

    if (user) {
      throw new BadRequestException();
    }
    // Hash Password
    createUser.password = await this.hashService.hashPassword(
      createUser.password,
    );
    return createUser.save();
  }

  async getUserByEmail(email: string) {
    return this.userModel
      .findOne({
        email,
      })
      .exec();
  }

  async findAll(): Promise<User[]> {
    return await this.userModel.find().exec();
  }
}
