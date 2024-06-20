import { Component } from 'react';
type Props = {
    value: number;
    direction: string;
    currency: string;
};
type State = {
    inputValue: number | undefined;
};
declare class StartingCashInput extends Component<Props, State> {
    constructor(props: Props);
    componentDidMount(): void;
    storeValue: () => void;
    handleInput: (event: any) => void;
    render(): JSX.Element;
}
export default StartingCashInput;
