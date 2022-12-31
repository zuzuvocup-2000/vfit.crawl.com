import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { IsString, Matches, MaxLength, MinLength } from 'class-validator';
import { Document } from 'mongoose';
@Schema()
export class User {
  @Prop({ required: true })
  name: string;

  @Prop({ required: true })
  email: string;

  @IsString()
  @MinLength(6)
  @MaxLength(32)
  @Prop({ required: true })
  @Matches(/((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/, {
    message: 'Password is too weak!',
  })
  password: string;

  @Prop({ required: false })
  otp: string;

  @Prop({ required: false })
  otpLive: Date;

  @Prop({ required: true, default: Date.now })
  createdAt: Date;

  @Prop({ required: false })
  logindAt: Date;
}

export type UserDocument = User & Document;

export const UserSchema = SchemaFactory.createForClass(User);