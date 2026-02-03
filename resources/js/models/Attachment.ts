import Model from './Model';

export default class Attachment extends Model {
  public name!: string;
  public filename!: string;
  public subtype!: string;
  public mediaType!: string;
  public encoding!: string;

  setAttributes(attributes: Partial<Attachment>) {
    this.name = attributes.name ?? this.name;
    this.filename = attributes.filename ?? this.filename;
    this.subtype = attributes.subtype ?? this.subtype;
    this.mediaType = attributes.mediaType ?? this.mediaType;
    this.encoding = attributes.encoding ?? this.encoding;
  }
}
