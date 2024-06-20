interface DocumentWithFullscreen extends Document {
    mozFullScreenElement?: Element;
    msFullscreenElement?: Element;
    webkitFullscreenElement?: Element;
    msExitFullscreen?: () => void;
    mozCancelFullScreen?: () => void;
    webkitExitFullscreen?: () => void;
}
export declare function isFullScreen(): boolean;
interface DocumentElementWithFullscreen extends HTMLElement {
    msRequestFullscreen?: () => void;
    mozRequestFullScreen?: () => void;
    webkitRequestFullscreen?: () => void;
}
export declare function requestFullScreen(element: DocumentElementWithFullscreen): void;
export declare function exitFullScreen(doc: DocumentWithFullscreen): void;
export declare function toogleFullScreen(): void;
export {};
