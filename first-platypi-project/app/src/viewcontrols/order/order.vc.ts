import {register} from 'platypus';
import BaseViewControl from '../base/base.vc';
import ProductsService from '../../services/products/products.svc';
import UserRepository from '../../repositories/user/user.repo';
import ConfirmationViewControl from '../confirmation/confirmation.vc';
import LoginViewControl from '../login/login.vc';

export default class OrderViewControl extends BaseViewControl {
    templateString: string = require('./order.vc.html');

    context: contexts.IOrder = {
        order: <models.IOrder> {
            productid: 0,
            address: '',
            city: '',
            state: '',
            zip: '',
            productsize: ''
        },
        error: ''
    };
    
    constructor(private productsService: ProductsService, private userRepository: UserRepository) {
        super();
    }
    
    navigatedTo(params: { id: string; }, query: any): void {
        this.context.order.productid = Number(params.id);
    }
    
    canNavigateTo() : boolean {
        if(this.userRepository.userid === 0) {
            this.navigator.navigate('login-vc');
            
            return false;
        }
    }
    
    placeOrder(): void {
        this.productsService.placeOrder(this.context.order).then((success) => {
            this.navigator.navigate(ConfirmationViewControl);
        }).catch((error) => {
            this.context.error = error;
        });
    }
}

register.viewControl('order-vc', OrderViewControl, [UserRepository, ProductsService]);
