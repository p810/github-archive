import {async, register} from 'platypus';
import BaseService from '../base/base.svc';

export default class UserService extends BaseService {
    register(email: string, password: string, firstname: string, lastname: string): async.IThenable<models.IUser> {
        var data = <models.IUser> {
            email: email,
            password: password,
            firstname: firstname,
            lastname: lastname
        };
        
        return this.json(this.api('/users/register'), data, 'POST');
    }
    
    login(email: string, password: string): async.IThenable<models.IUser> {   
        var data = <models.IUser> {
            email: email,
            password: password
        };
        
        // return this.json(this.api('/users/login'), data, 'POST', {
        //     success: (function(success: any) {
        //         return <models.IUser> {
        //             id: success.reponse.data,
        //             email: email
        //         }
        //     }),
            
        //     error: (function(error: any) {
        //         throw error.response.message;
        //     })
        // });
        
        return this.json(this.api('/users/login'), data, 'POST');
    }
}

register.injectable('user-svc', UserService);
