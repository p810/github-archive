import {register} from 'platypus';
import BaseViewControl from '../base/base.vc';
import HomeViewControl from '../home/home.vc';
import LoginViewControl from '../login/login.vc';
import UserRepository from '../../repositories/user/user.repo';

export default class RegisterViewControl extends BaseViewControl {
    templateString: string = require('./register.vc.html');

    context: contexts.IRegister = {
      firstname: '',
      lastname: '',
      email: '',
      password: '',
      error: '' 
    };
    
    constructor(private userRepository: UserRepository) {
        super();
    }
    
    register() : void {
        this.context.error = '';
        
        this.userRepository.register(
            this.context.email,
            this.context.password,
            this.context.firstname,
            this.context.lastname
        ).then(
            (success) => {
                this.navigator.navigate(LoginViewControl);
            }
        ).catch(
            (error) => {
                this.context.error = error;
            }
        );
    }
}

register.viewControl('register-vc', RegisterViewControl, [UserRepository]);
