export default abstract class Model {
  static create(attributes: object) {
    const instance = new (this as any)();

    instance.setAttributes(attributes);

    return instance;
  }

  abstract setAttributes(attributes: object): void;
}
