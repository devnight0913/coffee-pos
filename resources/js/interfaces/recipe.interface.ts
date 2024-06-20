
export interface IRecipe {
    id: string,
    name: string,
    image_path: string,
    description: string,
    price: number|undefined,
    is_active: number,
}