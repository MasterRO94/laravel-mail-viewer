import Model from './Model';
import Attachment from './Attachment';
import { Recipient } from '@/types';

export default class Email extends Model {
  public id!: number;
  public subject!: string;
  public from?: Recipient[];
  public to!: Recipient[];
  public cc: Recipient[] = [];
  public bcc: Recipient[] = [];
  public body!: string;
  public text?: string;
  public headers!: Record<string, string>;
  public attachments: Attachment[] = [];
  public payload?: string;
  public date!: string;
  public formattedDate!: string;
  public formattedTime!: string;
  public isNew: boolean = false;

  setAttributes(attributes: Partial<Email>) {
    this.id = attributes.id ?? this.id;
    this.subject = attributes.subject ?? this.subject;
    this.from = attributes.from ?? this.from;
    this.to = attributes.to ?? this.to;
    this.cc = attributes.cc ?? this.cc;
    this.bcc = attributes.bcc ?? this.bcc;
    this.body = attributes.body ?? this.body;
    this.text = attributes.text ?? this.text;
    this.headers = attributes.headers ?? this.headers;
    this.attachments = attributes.attachments?.map(a => Attachment.create(a)) ?? this.attachments;
    this.date = attributes.date ?? this.date;
    this.formattedDate = attributes.formattedDate ?? this.formattedDate;
    this.formattedTime = attributes.formattedTime ?? this.formattedTime;
  }

  markAsNew() {
    this.isNew = true;

    setTimeout(() => this.isNew = false, 100);

    return this;
  }
}
