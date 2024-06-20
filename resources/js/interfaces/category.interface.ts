import { ItemInterface } from "./item.inteface";

export interface ICategory {
  id : string,
  image_path : string | null,
  name : string,
  items : ItemInterface[],
}