import {async, Utils} from 'platypus';

export default class BaseService {
	protected static _inject: any = {
        http: async.Http,
        Promise: async.IPromise,
        utils: Utils
    };

	protected http: async.Http;
	protected Promise: async.IPromise;
	protected utils: Utils;

    host: string = 'http://platypisamples.azurewebsites.net/gettingstarted/api';
    
    json(url: string, data?: any, method: string = 'GET', handlers?: any) : async.IThenable<any> {
        var request_data = {
            method: method,
            url: url,
            data: data
        };
        
        if(handlers) {
            var out = this.http.json<models.IResponse>(request_data).then(
                (success) => {                    
                    var resp = handlers.success(success);
                    
                    console.log(resp);
                    
                    return resp;
                },
                
                (error) => {
                    return handlers.error(error);
                }
            );
        } else {
            var out = this.http.json<models.IResponse>(request_data).then(
                (success) => {
                    return success.response.data;
                },
                
                (error) => {
                    throw error.response.message;
                }
            );
        }
        
        return out;
    }
    
    api(endpoint: string = '') : string {
        return this.host + endpoint;
    }
}
