import {register, ui} from 'platypus';
import BaseViewControl from '../base/base.vc';
import PostsService from '../../services/posts/posts.svc';
import PostsRepository from '../../repositories/posts/posts.repo';
import UsersService from '../../services/users/users.svc';
import UsersRepository from '../../repositories/users/users.repo';
import ReadViewControl from '../read/read.vc';

export default class HomeViewControl extends BaseViewControl {
    templateString: string = require('./home.vc.html');

    context: any = {
        posts: <Array<models.IPost>>[],
        readView: ReadViewControl
    };
    
    constructor(private postsRepository: PostsRepository, private postsService: PostsService,
        private usersRepository: UsersRepository, private usersService: UsersService) {
        super();    
    }
    
    navigatedTo() : void {
        this.postsRepository.getPosts().then((posts) => {
            this.context.posts = posts;
        });
    }
    
    readPost(id: string) {
        this.navigator.navigate(ReadViewControl, {
            parameters: {
                id: id
            }
        });
    }
}

register.viewControl('home-vc', HomeViewControl, [PostsRepository, PostsService, UsersRepository, ReadViewControl]);
