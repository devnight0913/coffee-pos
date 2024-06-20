import React, { Component } from 'react';
import ReactDOM from 'react-dom/client';
import Swal from 'sweetalert2';
import { IRecipe } from '../interfaces/recipe.interface';
import httpService from '../services/http.service';
import { currency_format, swalConfig, t } from '../utils';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { isFullScreen, toogleFullScreen } from '../fullscreen';
import { ICustomer } from '../interfaces/customer.interface';
import { Modal } from 'bootstrap';
import uuid from 'react-uuid';
import { UserCircleIcon } from '@heroicons/react/24/solid';
import { XCircleIcon, ChevronDownIcon } from '@heroicons/react/24/outline';

interface ICartItem extends IRecipe {
    cartId: string;
    tax_rate: number | undefined;
    vat_type: string;
    discount: number | undefined;
    quantity: number | undefined;
    old_tax_rate: number;
    old_vat_type: string;
    old_discount: number;
    old_quantity: number;
}

type Props = {
    order: string;
    settings: any;
};

type State = {
    orderId: string;
    orderNumber: string;
    recipes: IRecipe[];
    customers: ICustomer[];
    customer: ICustomer | undefined;
    customerName: string | null;
    customerEmail: string | null;
    customerMobile: string | null;
    customerCity: string | null;
    customerBuilding: string | null;
    customerStreet: string | null;
    customerFloor: string | null;
    customerApartment: string | null;
    cart: ICartItem[];
    deletedRecipes: ICartItem[];
    showRecipes: boolean;
    categoryName: string | null;
    total: number;
    subtotal: number;
    tax: number | undefined;
    vatType: string;
    deliveryCharge: number | undefined;
    discount: number | undefined;
    tenderAmount: number | undefined;
    searchValue: string | null;
    remarks: string | null;
    isFullScreen: boolean;
    isLoading: boolean;
    isLoadingCategories: boolean;
    isPaid: boolean;
};

class PointOfSaleEdit extends Component<Props, State> {
    constructor(props: Props) {
        super(props);

        this.state = {
            orderId: '',
            orderNumber: '',
            recipes: [],
            cart: [],
            deletedRecipes: [],
            customers: [],
            customer: undefined,
            customerName: null,
            customerEmail: null,
            customerMobile: null,
            customerCity: null,
            customerBuilding: null,
            customerStreet: null,
            customerFloor: null,
            customerApartment: null,
            showRecipes: false,
            categoryName: null,
            subtotal: 0,
            total: 0,
            tax: 0,
            vatType: this.getAppSettings().vatType,
            deliveryCharge: 0,
            discount: 0,
            searchValue: null,
            remarks: null,
            isFullScreen: isFullScreen(),
            tenderAmount: 0,
            isLoading: false,
            isLoadingCategories: true,
            isPaid: true,
        };
    }

    getAppSettings = (): any => {
        return JSON.parse(this.props.settings);
    };

    componentDidMount() {
        this.setupForEditing().then(() => {
            this.calculateTotal();
        });
        this.getRecipes();
    }

    setupForEditing = async (): Promise<void> => {
        var order = JSON.parse(this.props.order);
        console.log(order);
        this.setState({ orderId: order.id });
        this.setState({ orderNumber: order.number });
        this.setState({ deliveryCharge: order.delivery_charge });
        this.setState({ tax: order.tax_rate });
        this.setState({ vatType: order.vat_type });
        this.setState({ discount: order.discount });
        this.setState({ isPaid: order.paid });

        let cartItems: ICartItem[] = [];

        order.order_details.map((item: any) => {
            let cartItem: ICartItem = {
                cartId: uuid(),
                id: item.recipe.id,
                name: item.recipe.name,
                image_path: item.recipe.image_path,
                description: item.recipe.description,
                quantity: item.quantity,
                old_quantity: item.quantity,
                tax_rate: item.tax_rate,
                vat_type: item.vat_type,
                discount: item.discount,
                old_tax_rate: item.tax_rate,
                old_vat_type: item.vat_type,
                old_discount: item.discount,
                price: item.price,
                is_active: item.recipe.is_active,
            };
            cartItems.push(cartItem);
        });
        this.setState({ cart: cartItems });

        if (order.customer) {
            this.setState({
                customer: {
                    id: order.customer.id,
                    name: order.customer.name,
                    full_address: order.customer.full_address,
                    contact: order.customer.contact,
                    order_details: []
                }
            });
        }
        this.setState({ tenderAmount: order.tender_amount });
        this.setState({ remarks: order.remarks });
    };

    randomString = (): string => {
        return (Math.random() + 1).toString(36).substring(2);
    };

    getRecipes = (): void => {
        // console.log("ASDASD");
        httpService
            .get(`/recipe/all`)
            .then((response: any) => {
                this.setState({ recipes: response.data.data });
            })
            .finally(() => {
                this.setState({ isLoadingCategories: false });
            });
    };

    updateOrder = (): void => {
        if (this.state.cart.length == 0) {
            toast.error(t('No items has been added!', 'لم يتم إضافة اية اصناف!'));
            return;
        }
        this.setState({ isLoading: true });
        httpService
            .post(`/orders/update/${this.state.orderId}`, {
                customer: this.state.customer,
                cart: this.state.cart,
                deletedRecipes: this.state.deletedRecipes,
                subtotal: this.state.subtotal,
                total: this.state.total,
                tax_rate: this.state.tax || 0,
                vat_type: this.state.vatType,
                delivery_charge: this.state.deliveryCharge || 0,
                discount: this.state.discount || 0,
                remarks: this.state.remarks,
                tender_amount: this.state.tenderAmount || 0,
                paid: this.state.isPaid,
                _method: 'PUT'
            })
            .then((response: any) => {
                if (response.data) {
                    this.closeModal('checkoutModal');
                    Swal.fire({
                        title: t('Updated', 'تم التحديث'),
                        text: t('Invoice has been updated!', '"تم تحديث الفاتورة!"'),
                        icon: 'success',
                        allowOutsideClick: false,
                        confirmButtonText: t('Continue', 'المتابعة')
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = `/orders/${this.state.orderId}`;
                        }
                    });
                }
            })
            .finally(() => this.setState({ isLoading: false }));
    };

    toggleFullScreen = (): void => {
        toogleFullScreen();
        this.setState({ isFullScreen: !this.state.isFullScreen });
    };
    goToOrderList = (): void => {
        window.location.href = '/orders';
    };
    
    calculateItemPrice = (item:ICartItem): number => {
        let price = (item.price || 0) * (item.quantity || 0) * ( 100 - Number(item.discount || 0) ) / 100.0;
        if(item.vat_type === "add") price = price + price * Number(item.tax_rate) / 100;
        else price = price - price * Number(item.tax_rate) / 100;
        return Number(price.toFixed(2));
    }
    
    calculateTotal = (): void => {
        let _total: number = 0;
        let _subtotal: number = 0;
        if (this.state.cart.length > 0) {
            this.state.cart.map((item: ICartItem) => {
                _subtotal += this.calculateItemPrice(item);
            });
        }
        let taxValue: number = 0;
        if (this.state.vatType == 'add') {
            if ((this.state.tax || 0) > 0 && (this.state.tax || 0) <= 100) {
                taxValue = (Number(this.state.tax || 0) * Number(_subtotal)) / 100;
            }
        }
        _total = Number(_subtotal) * ( 100 - Number(this.state.discount || 0) ) / 100.0 + Number(taxValue) + Number(this.state.deliveryCharge || 0);
        this.setState({ subtotal: _subtotal });
        this.setState({ total: _total });
        this.setState({ tenderAmount: _total });
    };

    getVat = (): number => {
        var vat = this.state.tax || 0;
        if (vat <= 0) return 0;
        var grossAmount = this.state.subtotal || 0;
        var taxAmount = this.getTaxAmount();
        return Math.round(Number(grossAmount) - Number(taxAmount));
    };

    getTaxAmount = (): number => {
        var vat = this.state.tax || 0;
        if (vat <= 0) return 0;
        var grossAmount = this.state.subtotal || 0;
        return Math.trunc(Number(grossAmount) / Number(Number(1) + Number(vat) / Number(100)));
    };

    getTotalTax = (): number => {
        let taxValue: number = 0;
        if (Number(this.state.tax || 0) > 0 && Number(this.state.tax || 0) <= 100) {
            taxValue = (Number(this.state.tax || 0) * Number(this.state.subtotal)) / 100;
        }
        return Number(taxValue);
    };

    handleDiscountChange = (event: React.ChangeEvent<HTMLInputElement>): void => {
        var value = event.target.value;
        if (Number(value) < 0) return;
        var discountValue = value == '' ? undefined : Number(value);
        this.setState({ discount: discountValue }, () => {
            this.calculateTotal();
        });
    };

    handleTaxChange = (event: React.ChangeEvent<HTMLInputElement>): void => {
        var value = event.target.value;
        if (Number(value) < 0) return;
        var taxValue = value == '' ? undefined : Number(value);
        this.setState({ tax: taxValue }, () => {
            this.calculateTotal();
        });
    };
    handleDeliveryChargeChange = (event: React.ChangeEvent<HTMLInputElement>): void => {
        var value = event.target.value;
        if (Number(value) < 0) return;
        var deliveryChargeValue = value == '' ? undefined : Number(value);
        this.setState({ deliveryCharge: deliveryChargeValue }, () => {
            this.calculateTotal();
        });
    };

    updateItemQuantity = (event: React.ChangeEvent<HTMLInputElement>, item: ICartItem): void => {
        var value = event.target.value;
        let cartItems = this.state.cart;
        let _prod = this.state.cart.find(p => p.cartId === item.cartId);
        if (!_prod) return;
        if (Number(value) < 0) return;
        _prod.quantity = value == '' ? undefined : Number(value);
        this.setState({ cart: cartItems }, () => {
            this.calculateTotal();
        });
    };

    updateItemVatType = (item: ICartItem): void => {
        let cartItems = this.state.cart;
        let _prod = this.state.cart.find(p => p.cartId === item.cartId);
        if (!_prod) return;
        _prod.vat_type = (item.vat_type === "exclude" ? "add" : "exclude");
        this.setState({ cart: cartItems }, () => {
            this.calculateTotal();
        });
    };

    updateItemVAT = (event: React.ChangeEvent<HTMLInputElement>, item: ICartItem): void => {
        var value = event.target.value;
        let cartItems = this.state.cart;
        let _prod = this.state.cart.find(p => p.cartId === item.cartId);
        if (!_prod) return;
        if (Number(value) < 0) return;
        _prod.tax_rate = value == '' ? undefined : Number(value);
        this.setState({ cart: cartItems }, () => {
            this.calculateTotal();
        });
    };

    updateItemDiscount = (event: React.ChangeEvent<HTMLInputElement>, item: ICartItem): void => {
        var value = event.target.value;
        let cartItems = this.state.cart;
        let _prod = this.state.cart.find(p => p.cartId === item.cartId);
        if (!_prod) return;
        if (Number(value) < 0) return;
        _prod.discount = value == '' ? undefined : Number(value);
        this.setState({ cart: cartItems }, () => {
            this.calculateTotal();
        });
    };

    updateItemPrice = (event: React.ChangeEvent<HTMLInputElement>, item: ICartItem): void => {
        var value = event.target.value;
        let cartItems = this.state.cart;
        let _prod = this.state.cart.find(p => p.cartId === item.cartId);
        if (!_prod) return;
        if (Number(value) < 0) return;
        _prod.price = value == '' ? undefined : Number(value);
        this.setState({ cart: cartItems }, () => {
            this.calculateTotal();
        });
    };
    currencyFormatValue = (number: any): any => {
        var settings = JSON.parse(this.props.settings);
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

    getChangeAmount = (): number => {
        return (this.state.tenderAmount || 0) - this.state.total;
    };
    handleTenderAmountChange = (event: React.ChangeEvent<HTMLInputElement>): void => {
        var value = event.target.value;
        if (Number(value) < 0) return;
        var tenderAmount = value == '' ? undefined : Number(value);
        this.setState({ tenderAmount: tenderAmount });
    };
    handleRemarksChange = (event: React.FormEvent<HTMLTextAreaElement>): void => {
        this.setState({ remarks: event.currentTarget.value });
    };
    removeItem = (item: ICartItem): void => {
        let newCartItems = this.state.cart.filter(i => i.cartId != item.cartId);
        this.setState({ cart: newCartItems }, () => {
            this.calculateTotal();
            this.setState({ deletedRecipes: [item, ...this.state.deletedRecipes] });
        });
    };

    togglePaidButton = (): void => {
        this.setState({ isPaid: !this.state.isPaid });
    }

    addToCart = (recipe: IRecipe): void => {
        let cartItem: ICartItem = {
            cartId: uuid(),
            id: recipe.id,
            name: recipe.name,
            image_path: recipe.image_path,
            description: recipe.description,
            price: recipe.price,
            is_active: recipe.is_active,
            vat_type: this.getAppSettings().vatType,
            tax_rate: 0,
            discount: 0,
            quantity: 1,
            old_vat_type: this.getAppSettings().vatType,
            old_tax_rate: 0,
            old_discount: 0,
            old_quantity: 0
        };

        this.setState({ cart: [cartItem, ...this.state.cart] }, () => {
            this.calculateTotal();
        });
    };

    // handleSearchSubmit = (event: React.FormEvent<HTMLFormElement>): void => {
    //     event.preventDefault();
    //     let search = this.state.searchValue;
    //     if (!search) return;
    //     let searchValue = search.toLowerCase().trim();
    //     let productFound = false;
    //     this.state.categories.map((category: ICategory) => {
    //         let _prod = category.products.find(
    //             p => p.name.toLowerCase().includes(searchValue) || p?.barcode?.toLowerCase() == searchValue || p?.sku?.toLowerCase() == searchValue
    //         );
    //         if (_prod) {
    //             this.addToCart(_prod);
    //             productFound = true;
    //             return;
    //         }
    //     });
    //     if (!productFound) {
    //         toast.error(t('No results found!', 'لم يتم العثور على نتائج!'));
    //     }
    // };
    handleSearchChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ searchValue: event.currentTarget.value });
    };

    handleCustomerSearchChange = (event: React.FormEvent<HTMLInputElement>): void => {
        var searchQuery = event.currentTarget.value.trim();
        if (!searchQuery) {
            this.setState({ customers: [] });
            return;
        }
        httpService
            .get(`/customers/search/all?query=${searchQuery}`)
            .then((response: any) => {
                this.setState({ customers: response.data.data });
            })
            .finally(() => {});
    };

    setCustomer = (customer: ICustomer): void => {
        this.setState({ customer: customer });
    };

    selectCustomer(customer: ICustomer) {
        this.setState({ customer: customer });
        this.closeModal('customerModal');
    }

    closeModal = (id: string): void => {
        const createModal = document.querySelector(`#${id}`);
        if (createModal) {
            var modalInstance = Modal.getInstance(createModal);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    };
    removeCustomer() {
        this.setState({ customer: undefined });
    }

    createCustomer = (e: React.FormEvent<HTMLFormElement>): void => {
        e.preventDefault();
        if (!this.state.customerName) {
            toast.error(t('Customer name is required!', 'اسم الزبون مطلوب!'));
            return;
        }
        this.setState({ isLoading: true });
        httpService
            .post(`/customers/create-new`, {
                name: this.state.customerName,
                email: this.state.customerEmail,
                mobile: this.state.customerMobile,
                city: this.state.customerCity,
                building: this.state.customerBuilding,
                street_address: this.state.customerStreet,
                floor: this.state.customerFloor,
                apartment: this.state.customerApartment
            })
            .then((response: any) => {
                this.setCustomer(response.data.data);
                this.setState({ customerName: '' });
                this.setState({ customerEmail: '' });
                this.setState({ customerMobile: '' });
                this.setState({ customerBuilding: '' });
                this.setState({ customerStreet: '' });
                this.setState({ customerFloor: '' });
                this.setState({ customerApartment: '' });
                var form = document.getElementById('create-customer-form') as HTMLFormElement;
                if (form) {
                    form.reset();
                }
                this.closeModal('createCustomerModal');
                toast.info(t('Customer has been created', 'تم إنشاء زبون جديد'));
            })
            .finally(() => {
                this.setState({ isLoading: false });
            });
    };
    handleVatTypeChange = (event: any): void => {
        this.setState({ vatType: event.target.value }, () => {
            this.calculateTotal();
        });
    };
    handleCustomerNameChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerName: event.currentTarget.value });
    };
    handleCustomerEmailChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerEmail: event.currentTarget.value });
    };
    handleCustomerMobileChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerMobile: event.currentTarget.value });
    };
    handleCustomerCityChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerCity: event.currentTarget.value });
    };
    handleCustomerStreetChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerStreet: event.currentTarget.value });
    };
    handleCustomerBuildingChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerBuilding: event.currentTarget.value });
    };
    handleCustomerFloorChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerFloor: event.currentTarget.value });
    };
    handleCustomerApartmentChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerApartment: event.currentTarget.value });
    };

    modalCloseButton = (): React.ReactNode => {
        return <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>;
    };

    render(): JSX.Element {
        return (
            <React.Fragment>
                <div className="d-flex py-3">
                    <div className=" flex-grow-1">
                        <button className="btn btn-outline-primary me-2" onClick={event => this.goToOrderList()}>
                            {t('Back', 'العودة')}
                        </button>
                        <button className="btn btn-light me-2 bg-white border" data-bs-toggle="modal" data-bs-target="#customerModal">
                            <span className="d-flex align-items-center">
                                <UserCircleIcon className="hero-icon me-1" /> {t('Customer', 'الزبون')}
                            </span>
                        </button>
                    </div>
                </div>

                <div className="row">
                    <div className="col-md-6">
                        <div className="card w-100 card-gutter rounded-0">
                            <div className="card-header bg-white border-bottom-0 p-0">
                                <div className="p-3">
                                    {t('Invoice', 'الفاتورة')} <span className="fw-bold">{this.state.orderNumber}</span>
                                </div>
                                <table className="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <td width={300} className="p-3 fw-bold">
                                                {t('Item', 'الصنف')}
                                            </td>
                                            <td width={150} className="text-center p-3 fw-bold">
                                                {t('Quantity', 'الكمية')}
                                            </td>
                                            <td width={150} className="text-center p-3 fw-bold">
                                                {t('VAT', 'الضريبة')} %
                                            </td>
                                            <td width={150} className="text-center p-3 fw-bold">
                                                {t('Discount', 'الخصم')} %
                                            </td>
                                            <td width={150} className="text-center p-3 fw-bold">
                                                {t('Total', 'المجموع')}
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div className="card-body p-0 overflow-auto" id="cartItems">
                                <table className="table table-bordered mb-0">
                                    <tbody>
                                        {this.state.cart.length > 0 ? (
                                            <React.Fragment>
                                                {this.state.cart.map((item: ICartItem) => {
                                                    return (
                                                        <tr key={item.cartId}>
                                                            <td width={300}>
                                                                <div className=" d-flex">
                                                                    <div className="me-2 d-flex align-items-center">
                                                                        <img src={item.image_path} alt="img" className="rounded-2" height={50} />
                                                                    </div>
                                                                    <div>
                                                                        <div className="fw-bold">{item.name}</div>
                                                                        <div className="fw-normal">
                                                                            <input
                                                                                type="number"
                                                                                className="form-control text-center"
                                                                                value={item.price}
                                                                                onFocus={e => e.target.select()}
                                                                                onChange={e => this.updateItemPrice(e, item)}
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                    <div className="ms-auto d-flex align-items-center">
                                                                        <XCircleIcon
                                                                            className="hero-icon-sm align-middle text-danger cursor-pointer user-select-none"
                                                                            onClick={event => this.removeItem(item)}
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td width={150} className="p-0 align-middle text-center">
                                                                <input
                                                                    type="number"
                                                                    className="form-control text-center fw-bold form-control-lg"
                                                                    value={item.quantity}
                                                                    onFocus={e => e.target.select()}
                                                                    onChange={event => this.updateItemQuantity(event, item)}
                                                                />
                                                            </td>
                                                            <td width={150} className="p-0 align-middle text-center">
                                                                <div onClick={event => this.updateItemVatType(item)}>{item.vat_type}</div>
                                                                <input
                                                                    type="number"
                                                                    className="form-control text-center fw-bold form-control-lg"
                                                                    value={item.tax_rate}
                                                                    onFocus={e => e.target.select()}
                                                                    onChange={event => this.updateItemVAT(event, item)}
                                                                />
                                                            </td>
                                                            <td width={150} className="p-0 align-middle text-center">
                                                                <input
                                                                    type="number"
                                                                    className="form-control text-center fw-bold form-control-lg"
                                                                    value={item.discount}
                                                                    onFocus={e => e.target.select()}
                                                                    onChange={event => this.updateItemDiscount(event, item)}
                                                                />
                                                            </td>
                                                            <td width={150} className="text-center align-middle">
                                                                {this.calculateItemPrice(item)}
                                                            </td>
                                                        </tr>
                                                    );
                                                })}
                                            </React.Fragment>
                                        ) : (
                                            <React.Fragment>
                                                <tr>
                                                    <td colSpan={3} className="p-3 text-center align-middle fs-5">
                                                        {t('No items added...', 'لا توجد اصناف مضافة ...')}
                                                    </td>
                                                </tr>
                                            </React.Fragment>
                                        )}
                                    </tbody>
                                </table>
                            </div>
                            <div className=" card-footer p-0 bg-white" id="orderDetails">
                                <table className="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td
                                                colSpan={3}
                                                width={200}
                                                className="text-center align-end clickable-cell"
                                                onClick={this.togglePaidButton}>
                                                {(this.state.isPaid === true) ? "Paid" : "Unpaid" }
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width={200}>
                                                {t('Customer', 'الزبون')}: {this.state.customer ? this.state.customer.name : 'N/A'}
                                                {this.state.customer && (
                                                    <div className="float-end">
                                                        <XCircleIcon
                                                            className="hero-icon-sm align-middle text-danger cursor-pointer user-select-none"
                                                            onClick={event => this.removeCustomer()}
                                                        />
                                                    </div>
                                                )}
                                            </td>
                                            <td width={200} className="text-end">
                                                {t('Subtotal', 'المجموع')}
                                            </td>
                                            <td width={200} className="align-middle text-center">
                                                {this.currencyFormatValue(this.state.subtotal)}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                width={200}
                                                className="text-start align-middle clickable-cell"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deliveryChargeModal">
                                                {t('Delivery Charge', 'رسوم التوصيل')}:{' '}
                                                {this.state.deliveryCharge ? this.currencyFormatValue(this.state.deliveryCharge) : 'N/A'}
                                            </td>
                                            <td
                                                width={200}
                                                className="text-end align-middle clickable-cell"
                                                data-bs-toggle="modal"
                                                data-bs-target="#discountModal">
                                                {t('Discount', 'الخصم')}
                                            </td>
                                            <td
                                                width={200}
                                                className="text-center text-danger align-middle clickable-cell"
                                                data-bs-toggle="modal"
                                                data-bs-target="#discountModal">
                                                {this.state.discount || 0}%
                                            </td>
                                        </tr>
                                        <tr className=" alert-success">
                                            {this.state.vatType == 'add' ? (
                                                <td
                                                    width={200}
                                                    className="text-start clickable-cell"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#taxModal">
                                                    {t('VAT', 'الضريبة')} {this.state.tax}%: {this.currencyFormatValue(this.getTotalTax())}
                                                </td>
                                            ) : (
                                                <td
                                                    width={200}
                                                    className="text-start clickable-cell"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#taxModal">
                                                    <div>
                                                        {t('TAX.AMOUNT', 'قيمة الضريبة')}: {this.currencyFormatValue(this.getTaxAmount())}
                                                    </div>
                                                    <div>
                                                        {t('VAT', 'الضريبة')} {this.state.tax}%: {this.currencyFormatValue(this.getVat())}
                                                    </div>
                                                </td>
                                            )}

                                            <td width={200} className="fw-bold text-end fs-5 align-middle">
                                                {t('Total', 'الإجمالي')}
                                            </td>
                                            <td width={200} className="text-center align-middle fw-bold fs-5">
                                                {this.currencyFormatValue(this.state.total)}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button
                                type="button"
                                className="btn btn-info py-4 rounded-0 shadow-sm fs-3 btn-lg w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#checkoutModal">
                                {t(' UPDATED CHECKOUT', 'تحديث')}
                            </button>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="card w-100 card-gutter rounded-0">
                            <div className="card-header bg-white">
                                <div className="d-flex px-0" style={{ minHeight: 'calc(1.5em + 1rem + 5px)', padding: '0.5rem' }}>
                                    <a className="text-decoration-none cursor-pointer pe-2 fs-5">
                                        {t('COFFEES', 'قهوة')}
                                    </a>
                                </div>
                            </div>

                            <div className="card-body overflow-auto py-0">
                                {this.state.isLoadingCategories && (
                                    <div className="py-5">
                                        <div className="d-flex justify-content-center m-2">
                                            <div className="spinner-border text-primary" role="status" style={{ width: '4rem', height: '4rem' }}>
                                                <span className="visually-hidden">{t('Loading...', 'جاري التحميل...')}</span>
                                            </div>
                                        </div>
                                        <div className="fw-bold h3 text-center">{t('Loading...', 'جاري التحميل...')}</div>
                                    </div>
                                )}

                                    <React.Fragment>
                                        {this.state.recipes.length > 0 && (
                                            <div className="row">
                                                {this.state.recipes.map((recipe: IRecipe) => {
                                                    return (
                                                        <div key={recipe.id} className="col-lg-4 col-md-4 col-sm-6 col-6 mb-0 p-0">
                                                            <div
                                                                className="position-relative w-100 border cursor-pointer user-select-none"
                                                                onClick={event => this.addToCart(recipe)}>
                                                                <picture>
                                                                    <source type="image/jpg" srcSet={recipe.image_path} />
                                                                    <img
                                                                        alt={recipe.name}
                                                                        src={recipe.image_path}
                                                                        aria-hidden="true"
                                                                        className="object-fit-cover h-100 w-100"
                                                                    />
                                                                </picture>
                                                                <div className="position-absolute bottom-0 start-0 h-100 d-flex flex-column align-items-center justify-content-center p-4 mb-0 w-100 cell-item-label text-center">
                                                                    <div className="product-name" dir="auto">
                                                                        {recipe.name}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    );
                                                })}
                                            </div>
                                        )}
                                    </React.Fragment>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="modal" id="discountModal" tabIndex={-1} aria-labelledby="discountModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="discountModalLabel">
                                    {t('Discount', 'الخصم')}
                                </h5>
                                {this.modalCloseButton()}
                            </div>
                            <div className="modal-body">
                                <h3 className="text-center">{this.state.discount || 0}%</h3>
                                <div className="mb-3">
                                    <input
                                        type="number"
                                        className="form-control form-control-lg text-center"
                                        onFocus={e => e.target.select()}
                                        value={this.state.discount}
                                        onChange={event => this.handleDiscountChange(event)}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="modal" id="deliveryChargeModal" tabIndex={-1} aria-labelledby="deliveryChargeModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title d-flex" id="deliveryChargeModalLabel">
                                    {t('Delivery Charge', 'رسوم التوصيل')}
                                </h5>
                                {this.modalCloseButton()}
                            </div>
                            <div className="modal-body">
                                <h3 className="text-center">{this.currencyFormatValue(this.state.deliveryCharge || 0)}</h3>
                                <div className="mb-3">
                                    <input
                                        type="number"
                                        className="form-control form-control-lg text-center"
                                        value={this.state.deliveryCharge}
                                        onFocus={e => e.target.select()}
                                        onChange={event => this.handleDeliveryChargeChange(event)}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal" id="taxModal" tabIndex={-1} aria-labelledby="taxModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="taxModalLabel">
                                    {t('VAT', 'الضريبة')}
                                </h5>
                                {this.modalCloseButton()}
                            </div>
                            <div className="modal-body">
                                <h3 className="text-center">{this.state.tax || 0}%</h3>
                                <div className="mb-3">
                                    <input
                                        type="number"
                                        className="form-control form-control-lg text-center"
                                        onFocus={e => e.target.select()}
                                        value={this.state.tax}
                                        onChange={event => this.handleTaxChange(event)}
                                    />
                                </div>
                                <div className="mb-3">
                                    <select
                                        name="vatType"
                                        id="vat-type"
                                        className="form-select form-select-lg"
                                        onChange={this.handleVatTypeChange}
                                        value={this.state.vatType}>
                                        <option value="exclude"> {t('Exclude', 'استثناء')}</option>
                                        <option value="add">{t('Add', 'إضافة')}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal" id="customerModal" tabIndex={-1} aria-labelledby="customerModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title d-flex" id="customerModalLabel">
                                    {t('Customer', 'الزبون')}
                                </h5>
                                {this.modalCloseButton()}
                            </div>
                            <div className="modal-body p-0">
                                <nav>
                                    <div className="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                                        <button
                                            className="nav-link rounded-0 active"
                                            id="nav-search-customer-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#nav-search-customer"
                                            type="button"
                                            role="tab"
                                            aria-controls="nav-search-customer"
                                            aria-selected="true">
                                            {t('Search', 'ابحث')}
                                        </button>
                                        <button
                                            className="nav-link rounded-0"
                                            id="nav-create-customer-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#nav-create-customer"
                                            type="button"
                                            role="tab"
                                            aria-controls="nav-create-customer"
                                            aria-selected="false">
                                            {t('Create', 'إنشاء')}
                                        </button>
                                    </div>
                                </nav>
                                <div className="tab-content" id="nav-tabContent">
                                    <div
                                        className="tab-pane fade show active"
                                        id="nav-search-customer"
                                        role="tabpanel"
                                        aria-labelledby="nav-search-customer-tab"
                                        tabIndex={0}>
                                        <div className="position-relative w-100">
                                            <input
                                                type="search"
                                                className="form-control form-control-lg rounded-0 shadow-none"
                                                name="search"
                                                id="search"
                                                autoComplete="off"
                                                placeholder={t('Search...', 'بحث...')}
                                                onChange={event => this.handleCustomerSearchChange(event)}
                                            />
                                        </div>
                                        <div className="overflow-auto" style={{ height: '250px' }}>
                                            {this.state.customers.length > 0 && (
                                                <React.Fragment>
                                                    {this.state.customers.map((cuts: ICustomer) => {
                                                        return (
                                                            <div
                                                                className="py-2 px-3 clickable-cell border-bottom"
                                                                onClick={e => this.selectCustomer(cuts)}
                                                                key={cuts.id}>
                                                                <div className="fw-bold">{cuts.name}</div>
                                                                <div className="small text-muted">{cuts.contact}</div>
                                                                <div className="small text-muted">{cuts.full_address}</div>
                                                            </div>
                                                        );
                                                    })}
                                                </React.Fragment>
                                            )}
                                        </div>
                                    </div>
                                    <div
                                        className="tab-pane fade p-3"
                                        id="nav-create-customer"
                                        role="tabpanel"
                                        aria-labelledby="nav-create-customer-tab"
                                        tabIndex={0}>
                                        <form method="POST" onSubmit={this.createCustomer} role="form" id="create-customer-form">
                                            <div className="mb-3">
                                                <label className=" form-label fw-bold">{t('Customer Name', 'اسم الزبون')}*</label>
                                                <input
                                                    type="text"
                                                    className="form-control form-control-lg"
                                                    onChange={event => this.handleCustomerNameChange(event)}
                                                />
                                            </div>
                                            <div className="mb-3">
                                                <label className=" form-label fw-bold">{t('Email', 'البريد الإلكتروني')}</label>

                                                <input
                                                    type="email"
                                                    className="form-control form-control-lg"
                                                    onChange={event => this.handleCustomerEmailChange(event)}
                                                />
                                            </div>
                                            <div className="mb-3">
                                                <label className=" form-label fw-bold">{t('Mobile Number', 'رقم الجوال')}</label>
                                                <input
                                                    type="tel"
                                                    className="form-control form-control-lg"
                                                    onChange={event => this.handleCustomerMobileChange(event)}
                                                />
                                            </div>
                                            <div className="text-muted">{t('Address', 'العنوان')}</div>
                                            <div className="mb-3">
                                                <label className=" form-label fw-bold">{t('City', 'المدينة')}</label>
                                                <input
                                                    type="text"
                                                    className="form-control form-control-lg"
                                                    onChange={event => this.handleCustomerCityChange(event)}
                                                />
                                            </div>
                                            <div className="row">
                                                <div className="col-md-6 mb-3">
                                                    <label className=" form-label fw-bold">{t('Street', 'الشارع')}</label>
                                                    <input
                                                        type="text"
                                                        className="form-control form-control-lg"
                                                        onChange={event => this.handleCustomerStreetChange(event)}
                                                    />
                                                </div>
                                                <div className="col-md-6 mb-3">
                                                    <label className=" form-label fw-bold">{t('Building', 'المبنى')}</label>
                                                    <input
                                                        type="text"
                                                        className="form-control form-control-lg"
                                                        onChange={event => this.handleCustomerBuildingChange(event)}
                                                    />
                                                </div>
                                            </div>
                                            <div className="row">
                                                <div className="col-md-6 mb-3">
                                                    <label className=" form-label fw-bold">{t('Floor', 'الطابق')}</label>
                                                    <input
                                                        type="text"
                                                        className="form-control form-control-lg"
                                                        onChange={event => this.handleCustomerFloorChange(event)}
                                                    />
                                                </div>
                                                <div className="col-md-6 mb-3">
                                                    <label className=" form-label fw-bold">{t('Apartment', 'الشقة')}</label>
                                                    <input
                                                        type="text"
                                                        className="form-control form-control-lg"
                                                        onChange={event => this.handleCustomerApartmentChange(event)}
                                                    />
                                                </div>
                                            </div>
                                            <button className="btn btn-primary btn-lg w-100" type="submit" disabled={this.state.isLoading}>
                                                {t('Create Customer', 'إنشاء زبون جديد')}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal fade" id="checkoutModal" tabIndex={-1} aria-labelledby="checkoutModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered modal-lg">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="checkoutModalLabel"></h5>
                                {this.modalCloseButton()}
                            </div>
                            <div className="modal-body py-0">
                                <div className="row">
                                    <div className="col-6 py-3 bg-primary-sec">
                                        <table className="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td className="text-danger-sec">{t('Subtotal', 'المجموع')}</td>
                                                    <td className="text-white">{this.currencyFormatValue(this.state.subtotal)}</td>
                                                </tr>
                                                <tr>
                                                    <td className="text-danger-sec"> {t('Quantity', 'الكمية')}</td>
                                                    <td className="text-white">
                                                        {this.state.cart.reduce(function (prev, current) {
                                                            return prev + +(current.quantity || 0);
                                                        }, 0)}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td className="text-danger-sec">{t('Discount', 'الخصم')}</td>
                                                    <td className="text-white">{this.currencyFormatValue(this.state.discount || 0)}</td>
                                                </tr>
                                                <tr>
                                                    <td className="text-danger-sec">{t('Delivery Charge', 'رسوم التوصيل')}</td>
                                                    <td className="text-white">{this.currencyFormatValue(this.state.deliveryCharge || 0)}</td>
                                                </tr>
                                                {this.state.vatType == 'add' ? (
                                                    <tr>
                                                        <td className="text-danger-sec">
                                                            {t('VAT', 'الضريبة')} {this.state.tax || 0}%
                                                        </td>
                                                        <td className="text-white">{this.currencyFormatValue(this.getTotalTax())}</td>
                                                    </tr>
                                                ) : (
                                                    <>
                                                        <tr>
                                                            <td className="text-danger-sec"> {t('Tax Amount', 'القيمة الضريبية')}</td>
                                                            <td className="text-white">{this.currencyFormatValue(this.getTaxAmount())}</td>
                                                        </tr>
                                                        <tr>
                                                            <td className="text-danger-sec">
                                                                {t('VAT', 'الضريبة')} {this.state.tax || 0}%
                                                            </td>
                                                            <td className="text-white">{this.currencyFormatValue(this.getVat())}</td>
                                                        </tr>
                                                    </>
                                                )}
                                                <tr className="fw-bold">
                                                    <td className="text-danger-sec">{t('Total', 'المجموع الإجمالي')}</td>
                                                    <td className="text-white">{this.currencyFormatValue(this.state.total)}</td>
                                                </tr>
                                                {this.state.customer && (
                                                    <React.Fragment>
                                                        <tr>
                                                            <td className="text-danger-sec align-middle">{t('Customer', 'الزبون')}</td>
                                                            <td className="text-white">{this.state.customer.name}</td>
                                                        </tr>
                                                        <tr>
                                                            <td className="text-danger-sec align-middle">{t('Contact', 'الاتصال')}</td>
                                                            <td className="text-white">{this.state.customer.contact}</td>
                                                        </tr>
                                                        <tr>
                                                            <td className="text-danger-sec align-middle">{t('Address', 'العنوان')}</td>
                                                            <td className="text-white">{this.state.customer.full_address}</td>
                                                        </tr>
                                                    </React.Fragment>
                                                )}
                                            </tbody>
                                        </table>
                                        <hr />
                                        <div className="mb-3">
                                            <label htmlFor="remarks" className="form-label text-danger-sec">
                                                {t('Notes', 'الملاحظات')}
                                            </label>
                                            <textarea
                                                className="form-control"
                                                id="remarks"
                                                rows={3}
                                                onChange={event => this.handleRemarksChange(event)}
                                                value={this.state.remarks || ''}></textarea>
                                        </div>
                                    </div>
                                    <div className="col-6 py-3 bg-light d-flex flex-column">
                                        <div className="text-center text-danger">{t('CHECKOUT', 'الدفع')}</div>
                                        <hr />
                                        <div className="mb-3">
                                            <div className="form-label text-center">{t('Tender Amount', 'المبلغ المدفوع')}</div>
                                            <input
                                                type="number"
                                                className="form-control form-control-lg text-center"
                                                id="tender-amount"
                                                value={this.state.tenderAmount}
                                                onFocus={e => e.target.select()}
                                                onChange={event => this.handleTenderAmountChange(event)}
                                            />
                                        </div>
                                        <hr />
                                        <table className="table table-borderless d-none">
                                            <tbody>
                                                <tr className="fw-bold">
                                                    <td className="text-danger-sec">
                                                        {this.getChangeAmount() < 0 ? t('Owe', 'مدين') : t('Change', 'الباقي')}
                                                    </td>
                                                    <td className="text-end">{this.currencyFormatValue(this.getChangeAmount())}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div className="mt-auto">
                                            <button
                                                className="btn btn-info border btn-lg w-100"
                                                disabled={this.state.isLoading}
                                                onClick={e => this.updateOrder()}>
                                                {t('UPDATE', 'تحديث')}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ToastContainer position="bottom-left" autoClose={2000} pauseOnHover theme="colored" hideProgressBar={true} />
            </React.Fragment>
        );
    }
}
export default PointOfSaleEdit;

const element = document.getElementById('pos-edit');
if (element) {
    const props = Object.assign({}, element.dataset);
    const root = ReactDOM.createRoot(element);
    root.render(<PointOfSaleEdit order={''} settings={''} {...props} />);
}
