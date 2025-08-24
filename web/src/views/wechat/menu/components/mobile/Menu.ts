// 微信公众号菜单
export interface Menu {
    name: string,
    type: string,
    key?: string,
    url?: string,
    media_id?: string|number,
    appid?: string,
    pagepath?: string
    article_id?:string|number
}

// 微信公众号集合
export interface Button {
    name: string,
    type?: string,
    key?: string,
    sub_buttons: Array<Menu>
}

// 微信公众号底部 buttons
export interface Buttons {
    buttons: Array<Button>
}
