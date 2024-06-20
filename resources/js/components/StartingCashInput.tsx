import React, { Component } from 'react';
import ReactDOM from 'react-dom/client';
import { toast, ToastContainer } from 'react-toastify';
import httpService from '../services/http.service';
import { t } from '../utils';

type Props = {
    value: number;
    direction: string;
    currency: string;
};
type State = {
    inputValue: number | undefined;
};
class StartingCashInput extends Component<Props, State> {
    constructor(props: Props) {
        super(props);

        this.state = {
            inputValue: this.props.value
        };
    }
    componentDidMount() {}
    storeValue = (): void => {
        httpService
            .post(`/settings/starting-cash`, {
                value: this.state.inputValue || 0
            })
            .then((response: any) => {
                if (response.data) {
                    toast.info(t('Saved!', 'تم الحفظ'), {
                        toastId: 'info-toast'
                    });
                }
            });
    };
    handleInput = (event: any): void => {
        var value = event.target.value;
        if (Number(value) < 0) return;
        var startingCashValue = value == '' ? undefined : Number(value);
        this.setState({ inputValue: startingCashValue }, () => this.storeValue());
    };
    render(): JSX.Element {
        return (
            <React.Fragment>
                <div className="mb-3">
                    <label htmlFor="starting-cash" className="form-label">
                        {t('Starting cash', 'الرصيد الافتتاحي')} ({this.props.currency})
                    </label>
                    <input
                        type="number"
                        dir="ltr"
                        className={`form-control form-control-lg ${this.props.direction == 'rtl' ? 'text-start' : ''}`}
                        value={this.state.inputValue}
                        onFocus={e => e.target.select()}
                        onInput={this.handleInput.bind(this)}
                    />
                </div>
                <ToastContainer position="bottom-left" autoClose={2000} pauseOnHover theme="colored" hideProgressBar={true} />
            </React.Fragment>
        );
    }
}
export default StartingCashInput;

const element = document.getElementById('starting-cash-input');
if (element) {
    const root = ReactDOM.createRoot(element);
    const props = Object.assign({}, element.dataset);
    root.render(<StartingCashInput value={0} direction={'ltr'} currency={''} {...props} />);
}
