export interface ItemInterface {
  id: string,
  category_id: string,
  supplier_id: string,
  image_path: string | null,
  name : string,
  description : string | null,
  cost: number | undefined,
  price: number | undefined,
  in_stock : number | 0,
  unit: number | undefined,
  is_active: 1 | 0,
}