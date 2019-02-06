import {async, register} from 'platypus';
import BaseRepository from '../base/base.repo';
import ProductsService from '../../services/products/products.svc';

export default class ProductsRepository extends BaseRepository {
    products: Array<models.IProduct>;
    
    constructor(private productService: ProductsService) {
        super();
    }
    
    getProducts() : async.IThenable<Array<models.IProduct>> {
        return this.productService.getProducts().then((products) => {
            this.products = products;
            
            return this.products;
        });
    }
}

register.injectable('products-repo', ProductsRepository);
