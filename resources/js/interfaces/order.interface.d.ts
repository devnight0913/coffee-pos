export interface IOrder {
    id: string;
    number: string;
    delivery_charge: number;
    tax_rate: number;
    discount: number;
    order_details: {
        item_name: string;
        item_image_url: string;
        quantity: number;
        price: number;
        cost: number;
    }[];
    table_name: string;
    customer: {
        id: string;
        name: string;
    };
}
