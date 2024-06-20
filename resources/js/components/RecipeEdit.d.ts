import React, { Component } from 'react';
import 'react-toastify/dist/ReactToastify.css';
interface ICategory {
    id: string;
    name: string;
    image_path: string;
    sort_order: number;
    is_active: number;
}
interface IItem {
    id: string;
    category_id: string;
    image_path: string;
    name: string;
    description: string;
    cost: number;
    in_stock: number;
    is_active: number;
    unit: number;
}
interface IItemListItem {
    category_id: string;
    category_name: string;
    item_id: string;
    item_name: string;
    amount: number;
    cost: number;
    unit: number;
}
type Props = {
    recipe: any;
    items: any;
    settings: any;
};
type State = {
    categories: Array<ICategory>;
    items: Array<IItem>;
    selectedCategory: number;
    selectedItem: number;
    selectedAmount: number;
    itemList: Array<IItemListItem>;
    isLoading: boolean;
    recipeId: string;
    name: string;
    description: string;
    status: number;
    price: string;
};
declare class RecipeEdit extends Component<Props, State> {
    constructor(props: Props);
    componentDidMount(): void;
    initializeData: () => void;
    categorySelected: (event: any) => void;
    itemSelected: (event: any) => void;
    amountChanged: (event: any) => void;
    addItemButtonClicked: () => void;
    deleteItem: (data: any) => void;
    getCategories: () => void;
    getItems: () => void;
    currencyFormatValue: (number: any) => any;
    getAppSettings: () => any;
    saveRecipe: () => void;
    handleNameChange: (event: React.FormEvent<HTMLInputElement>) => void;
    handleDescriptionChange: (event: React.FormEvent<HTMLTextAreaElement>) => void;
    handleStatusChange: (event: React.FormEvent<HTMLSelectElement>) => void;
    handlePriceChange: (event: React.FormEvent<HTMLInputElement>) => void;
    render(): React.JSX.Element;
}
export default RecipeEdit;
