import Model from './Model';

export default class Metric extends Model {
  public key: string = '';
  public value: number = 0;
  public title: string = '';

  setAttributes(attributes: Partial<Metric>) {
    this.key = attributes.key ?? this.key;
    this.value = attributes.value ?? this.value;
    this.title = attributes.title ?? this.title;
  }
}
