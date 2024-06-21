import React, { Component } from 'react';
import ReactDOM from 'react-dom/client';
import httpService from '../services/http.service';
import { ToastContainer, toast } from 'react-toastify';
import { currency_format, t } from '../utils';
import 'react-toastify/dist/ReactToastify.css';

const unitList = ["gr", "ps", "ml", "kg"];
interface ICategory {
    id: string,
    name: string,
    image_path: string,
    sort_order: number,
    is_active: number,
};

interface IItem {
    id: string,
    category_id: string,
    image_path: string,
    name: string,
    description: string,
    cost: number,
    in_stock: number,
    is_active: number,
    unit: number
};

interface IItemListItem {
    category_id: string,
    category_name: string,
    item_id: string,
    item_name: string,
    amount: number,
    cost: number,
    unit: number
};

const statusValues = [
    "Hidden",
    "For Sale"
]

type Props = {
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
    name: string;
    description: string;
    status: number;
    price: string;
};

class RecipeCreate extends Component<Props, State> {
    constructor(props: Props) {
        super(props);

        this.state = {
            categories: [],
            items: [],
            name: "",
            description: "",
            price: "",
            status: 0,
            selectedCategory: 0,
            selectedItem: 0,
            selectedAmount: 0,
            itemList: [],
            isLoading: true,
        };
    }
    componentDidMount() {

        this.getCategories();
        this.getItems();
        
        this.initializeData();
    }

    initializeData = () => {
        this.setState({ itemList: []});
    }

    categorySelected = (event: any) => {
        const index = this.state.categories.findIndex((category: any) => category.name === event.target.value);
        // this.setState({ selectedCategory: this.state.categories[index] });
        console.log("INDEX", index);
        this.setState({ selectedCategory: index});
        this.setState({ selectedItem: 0});
    }

    itemSelected = (event: any) => {
        const index = this.state.items.filter((filteredData: IItem) => filteredData.category_id === this.state.categories[this.state.selectedCategory].id  && filteredData.is_active === 1)
                .findIndex((item: any) => item.name === event.target.value);
        this.setState({ selectedItem: index});
    }

    amountChanged = (event: any) => {
        this.setState({ selectedAmount: event.target.value })
    }

    addItemButtonClicked = () => {
        if(this.state.categories.length === 0) return;
        if(this.state.items.length === 0) return;
        console.log(this.state.selectedCategory);
        console.log(this.state.selectedItem);
        const item = this.state.items.filter((filteredData: IItem) => filteredData.category_id === this.state.categories[this.state.selectedCategory].id  && filteredData.is_active === 1)[this.state.selectedItem];
        console.log(item);
        const data = {
            category_name: this.state.categories[this.state.selectedCategory].name,
            item_name: item.name,
            category_id: this.state.categories[this.state.selectedCategory].id,
            item_id: item.id,
            amount: this.state.selectedAmount,
            cost: item.cost * this.state.selectedAmount,
            unit: item.unit
        };
        this.setState({ itemList: [...this.state.itemList, data] });
    }

    deleteItem = (data: any) => {
        const filteredList = this.state.itemList.filter((list: any) => list.item_id !== data.item_id);
        this.setState({ itemList: filteredList });
    }

    getCategories = (): void => {
        httpService
            .get(`/categories/all`)
            .then((response: any) => {
                this.setState({ categories: response.data.categories });
                console.log(response.data.categories);
                
            });
    };

    getItems = (): void => {
        httpService
            .get(`/items/all`)
            .then((response: any) => {
                this.setState({ items: response.data });
                console.log(response.data);
            })
            .finally(() => {
                this.setState({ isLoading: false });
            });
    };

    currencyFormatValue = (number: any): any => {
        var settings = this.getAppSettings();
        return currency_format(
            number,
            settings.currencyPrecision,
            settings.currencyDecimalSeparator,
            settings.currencyThousandSeparator,
            settings.currencyPosition,
            settings.currencySymbol,
            settings.trailingZeros
        );
    };
    
    getAppSettings = (): any => {
        return JSON.parse(this.props.settings);
    };

    saveRecipe = (): void => {
        this.setState({ isLoading: true });
        httpService
            .post(`/recipe`, {
                name: this.state.name,
                price: parseFloat(this.state.price),
                description: this.state.description,
                status: (this.state.status === 1)?"available":"unavailable",
                items: this.state.itemList
            })
            .then((response: any) => {
                if (response.data) {
                    toast.info(t('Saved!', 'تم الحفظ'));
                    this.initializeData();
                }
            })
            .finally(() => {
                this.setState({ isLoading: false });
            });
    };

    handleNameChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ name: event.currentTarget.value });
    };
    handleDescriptionChange = (event: React.FormEvent<HTMLTextAreaElement>): void => {
        this.setState({ description: event.currentTarget.value });
    };
    handleStatusChange = (event: React.FormEvent<HTMLSelectElement>) => {
         this.setState({ status: (event.currentTarget.value === statusValues[0])?0:1 });
    }
    handlePriceChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ price: event.currentTarget.value });
    };

    render() {
        const tempItemList = this.state.itemList;
        const totalSum = (tempItemList.length === 0 ? 0 : tempItemList.reduce((prevValue: number, item: any) => {
            return prevValue + item.cost;
        }, 0));
        return (
            <>
                {this.state.isLoading ? (
                    <div className="py-5">
                        <div className="d-flex justify-content-center m-2">
                            <div className="spinner-border text-primary" role="status" style={{ width: '4rem', height: '4rem' }}>
                                <span className="visually-hidden">{t('Loading...', 'جاري التحميل...')}</span>
                            </div>
                        </div>
                        <div className="fw-bold h3 text-center">{t('Loading...', 'جاري التحميل...')}</div>
                    </div>
                ) : (
                    <>
                        <div className='row'>
                            <div className='col-md-6 d-flex align0-itmes-stretch mb-3'>
                                <div className='card shadow-sm border-0 rounded-3 w-100'>
                                    <div className='px-4 py-4'>
                                        <div className="mb-3">
                                            <h6 className='m-0 fw-bold'>
                                                {t('Recipe Name', 'اسم القهوة')}
                                            </h6>
                                            <input
                                                type="text"
                                                className="form-control form-control-lg"
                                                value={this.state.name}
                                                onChange={event => this.handleNameChange(event)}
                                            />
                                        </div>
                                        <div className="mb-3">
                                            <h6 className='m-0 fw-bold'>
                                                {t('Description', 'وصف')}
                                            </h6>
                                            <textarea
                                                className="form-control form-control-lg"
                                                rows={2}
                                                value={this.state.description}
                                                onChange={event => this.handleDescriptionChange(event)}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className='col-md-6 d-flex align0-itmes-stretch mb-3'>
                                <div className='card shadow-sm border-0 rounded-3 w-100'>
                                    <div className='px-4 py-4'>
                                        <div className="mb-3">
                                            <h6 className='m-0 fw-bold'>
                                                {t('Status', 'حالة')}
                                            </h6>
                                            <select
                                                name="vatType"
                                                id="vat-type"
                                                className="form-select form-select-lg"
                                                onChange={(event) => this.handleStatusChange(event)}
                                            >
                                                <option value={statusValues[0]} selected={this.state.status === 0}>{t(statusValues[0], 'للبيع')}</option>
                                                <option value={statusValues[1]} selected={this.state.status === 1}>{t(statusValues[1], 'مختفي')}</option>
                                            </select>
                                        </div>
                                        <div className="mb-3">
                                            <h6 className='m-0 fw-bold'>
                                                {t('Price', 'سعر')}
                                            </h6>
                                            <input
                                                type="number"
                                                className="form-control form-control-lg"
                                                value={this.state.price}
                                                onChange={event => this.handlePriceChange(event)}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-6 d-flex align0-itmes-stretch mb-3'>
                                <div className='card shadow-sm border-0 rounded-3 w-100'>
                                    <div className='px-4 py-4'>
                                        <div className="mb-3">
                                            <h6 className='m-0 fw-bold'>
                                                {t('Category', 'فئة')}
                                            </h6>
                                            <select
                                                name="vatType"
                                                id="vat-type"
                                                className="form-select form-select-lg"
                                                onChange={(event) => this.categorySelected(event)}
                                            >
                                                {this.state.categories.map((category: ICategory, index: number) => (
                                                    <option key={index} value={category.name} selected={index === this.state.selectedCategory}>{category.name}</option>
                                                ))}
                                            </select>
                                        </div>
                                        <div className="mb-3">
                                            <h6 className='m-0 fw-bold'>
                                                {t('Item', 'المكونات')}
                                            </h6>
                                            <select
                                                name="vatType"
                                                id="vat-type"
                                                className="form-select form-select-lg"
                                                onChange={(event) => this.itemSelected(event)}
                                            >
                                                {this.state.items.filter((filteredData: IItem) => filteredData.category_id === this.state.categories[this.state.selectedCategory].id  && filteredData.is_active === 1)
                                                .map((item: IItem, index: number) => (
                                                    <option key={index} value={item.name} selected={index === this.state.selectedItem}>{item.name}</option>
                                                ))}
                                            </select>
                                        </div>
                                        <div className="mb-3">
                                            <h6 className='m-0 fw-bold'>
                                                {t('Amount', 'كمية')}
                                            </h6>
                                            <input
                                                type="text"
                                                className="form-control form-control-lg"
                                                value={this.state.selectedAmount}
                                                onChange={(event) => this.amountChanged(event)}
                                            />
                                        </div>
                                        <div className="mb-3">
                                            <button
                                                className="btn btn-primary btn-lg float-end"
                                                type="submit"
                                                onClick={this.addItemButtonClicked}
                                            >
                                                {t('Add Item', 'أضف المكون')}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className='col-md-6 d-flex align0-itmes-stretch mb-3'>
                                <div className='card shadow-sm border-0 rounded-3 w-100'>
                                    <div className='px-4 py-4' style={{overflowX: "auto"}}>
                                        <div className='card-title h4' style={{ color: '#757575' }}>
                                            {t('Item List', 'قائمة المكونات')}
                                        </div>
                                        <div style={{overflowX: "auto"}}>
                                        <table className='table table-hover table-striped mb-0 align-middle w-100 dataTable no-footer'>
                                            <thead className='bg-gray-50'>
                                                <tr>
                                                    <td className='text-muted font-medium px-4 py-3 text-uppercase small text-start whitespace-nowrap tracking-wider'>
                                                        {t('Category', 'فئة')}
                                                    </td>
                                                    <td className='text-muted font-medium px-4 py-3 text-uppercase small text-start whitespace-nowrap tracking-wider'>
                                                        {t('Item', 'المكونات')}
                                                    </td>
                                                    <td className='text-muted font-medium px-4 py-3 text-uppercase small text-start whitespace-nowrap tracking-wider'>
                                                        {t('Amount', 'كمية')}
                                                    </td>
                                                    <td className='text-muted font-medium px-4 py-3 text-uppercase small text-start whitespace-nowrap tracking-wider'>
                                                        {t('Cost', 'يكلف')}
                                                    </td>
                                                    <td className='text-muted font-medium px-4 py-3 text-uppercase small text-start whitespace-nowrap tracking-wider'>
                                                        {t('Action', 'فعل')}
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {this.state.itemList.map((data: any, index: number) => (
                                                    <tr className={index % 2 === 0 ? 'odd' : 'even'} key={index}>
                                                        <td>{data.category_name}</td>
                                                        <td>{data.item_name}</td>
                                                        <td>{data.amount + unitList[data.unit - 1]}</td>
                                                        <td>{this.currencyFormatValue(data.cost)}</td>
                                                        <td>
                                                            <button
                                                                className='btn btn-danger px-3 py-2 d-flex align-items-center justify-content-center font-medium shadow-sm rounded-2 small'
                                                                style={{ lineHeight: '1.25rem' }}
                                                                onClick={() => this.deleteItem(data)}
                                                            >
                                                                <svg className="hero-icon-sm me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" aria-hidden="true">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                                                </svg>
                                                                {t('Delete', 'يمسح')}
                                                            </button>
                                                        </td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                        </div>
                                        <h6 className='m-0 fw-bold float-end'>
                                            {t('Whole Cost', 'التكلفة الكاملة')}: {this.currencyFormatValue(totalSum)}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className='card shadow-sm border-0 rounded-3 w-100 mb-3'>
                            <div className='px-4 py-4'>
                                <div className='mb-5'>
                                    <h6 className='m-0 fw-bold'>
                                        {t('Image', 'صورة')}
                                    </h6>
                                    <input
                                        className="form-control"
                                        name="image"
                                        type="file"
                                        id="image-input"
                                        accept="image/png, image/jpeg"
                                    />
                                    <p style={{ fontSize: "0.875rem", marginTop: "0.25rem", color: '#757575' }}>
                                        {t('Choose an image', 'اختر صورة')}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="mb-3">
                            <button
                                className='btn btn-primary px-4 py-2 d-flex align-items-center justify-content-center font-medium shadow-sm rounded-2 small'
                                style={{ lineHeight: '1.25rem' }}
                                onClick={this.saveRecipe}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" className="me-2 d-flex align-middle" style={{ width: "1.25rem", height: "1.25rem" }}>
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                {t('Save Recipe', 'حفظ القهوة')}
                            </button>
                        </div>
                        <ToastContainer position="bottom-left" autoClose={2000} pauseOnHover theme="colored" hideProgressBar={true} />
                    </>
                )}
            </>
        );
    }
}
export default RecipeCreate;

const element = document.getElementById('recipe-create');
if (element) {
    const props = Object.assign({}, element.dataset);
    const root = ReactDOM.createRoot(element);
    root.render(<RecipeCreate settings={''} {...props} />);
}
