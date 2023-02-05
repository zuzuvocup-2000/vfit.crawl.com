import {
  BadRequestException,
  Injectable,
} from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import { User, UserDocument } from './schema/user.schema';
import { CreateUserRequest } from './dto/create-user.request';
import { HashService } from './hash.service';
import { ChangePasswordUserRequest } from './dto/chang-password.request';
import { CODES } from 'src/common/constants/code';
import { UpdateUserRequest } from './dto/update-user.request';
import { CollectionResponse, DocumentCollector } from '@forlagshuset/nestjs-mongoose-paginate';
import { GetPaginateDto } from 'src/common/params/get-paginate.dto';

@Injectable()
export class UserService {
  constructor(
    @InjectModel(User.name) private userModel: Model<UserDocument>,
    private hashService: HashService,
  ) {}

  /**
   * Api detail user
   * @params id
   * @return Site
   * */
  async getById(id: string): Promise<UserDocument> {
    const site = await this.userModel.findById(id).exec();
    return site;
  }

  /**
   * Api get list users
   * @param filter
   * @param page
   * @param limit
   * @return array User
   * */
  async paginate(
    getPaginateDto: GetPaginateDto,
  ): Promise<CollectionResponse<UserDocument>> {
    const collector = new DocumentCollector<UserDocument>(this.userModel);
    return collector.find({
      filter: {
        $or: [
          { name: { $regex: new RegExp(getPaginateDto.keyword, "i") } },
          { email: { $regex: new RegExp(getPaginateDto.keyword, "i") } }
        ]
      },
      page: getPaginateDto.page,
      limit: getPaginateDto.limit,
    });
  }

  async updateUser(updateUserRequest: UpdateUserRequest) {
    const user = await this.getUserByEmail(updateUserRequest.email);
    if (!user) {
      return {
        'message': 'Tài khoản không tồn tại!',
        'code': CODES.BAD_REQUEST
      };
    }
    if (updateUserRequest.email != updateUserRequest.newEmail) {
      if (await this.getUserByEmail(updateUserRequest.newEmail)) {
        return {
          'message': 'Email đã tồn tại trong hệ thống!',
          'code': CODES.BAD_REQUEST
        };
      }
    }
    await this.userModel.updateOne({ _id: user['_id'] }, { name: updateUserRequest.name, email: (updateUserRequest.newEmail != updateUserRequest.email ? updateUserRequest.newEmail : updateUserRequest.email) });
    return {
      'message': 'Cập nhật tài khoản thành công!',
      'code': CODES.SUCCESS,
    };
  }

  async changePassword(changePasswordUserRequest: ChangePasswordUserRequest) {
    const user = await this.validateUser(changePasswordUserRequest.email, changePasswordUserRequest.password);
    if (!user) {
      return {
        'message': 'Mật khẩu cũ không chính xác!',
        'code': CODES.BAD_REQUEST
      };
    }
    const password = await this.hashService.hashPassword(
      changePasswordUserRequest.newPassword,
    );
    await this.userModel.updateOne({ _id: user['_id'] }, { password });
    return {
      'message': 'Đổi mật khẩu thành công!',
      'code': CODES.SUCCESS,
    };
  }

  async validateUser(email: string, pass: string): Promise<unknown> {
    const user = await this.getUserByEmail(email);
    if (user && (await this.hashService.comparePassword(pass, user.password))) {
      return user;
    }
    return null;
  }

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
