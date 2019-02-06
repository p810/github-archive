import {async, register} from 'platypus';
import BaseService from '../base/base.svc';

export default class APIService extends BaseService {
    host: string = 'https://api.myjson.com';
    
    /**
     * These properties define the IDs of the MyJSON resources that store our data.
     */
    posts: string = '2arnm';
    users: string = '51fcq';
    
    usersURL(): string {
        return (this.host + '/bins/' + this.users);
    }
    
    postsURL(): string {
        return (this.host + '/bins/' + this.posts);
    }
}

register.injectable('api-svc', APIService);
