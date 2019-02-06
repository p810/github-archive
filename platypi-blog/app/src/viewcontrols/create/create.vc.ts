import {register, ui} from 'platypus';
import BaseViewControl from '../base/base.vc';
import PostsRepository from '../../repositories/posts/posts.repo';
import PostsService from '../../services/posts/posts.svc';
import ReadViewControl from '../read/read.vc';

export default class CreateViewControl extends BaseViewControl {
    templateString: string = require('./create.vc.html');

    context: any = {};
    postId: number = 0;
    
    constructor(private postsRepository: PostsRepository, private postsService: PostsService) {
        super();
    }
    
    
    loaded(): void {
        var form = document.getElementById('postForm');
        
        form.addEventListener('submit', (event: Event) => {
            event.preventDefault();
            
            var form = (<HTMLFormElement> document.getElementById('postForm'));
            
            var data: any = {},
                title = <HTMLInputElement> form.elements.namedItem('title'),
                body  = <HTMLInputElement> form.elements.namedItem('body');
            
            data['title']    = title.value;
            data['body']     = body.value;
            data['userid']   = 1;
            data['username'] = 'Payton';
            
            // We need to determine the ID of this post. So we take the length of PostsRepository.posts and add one.
            this.postsRepository.getPosts().then((posts) => {                                
                data['id'] = posts.length + 1;
                
                posts.push(data);
                
                this.postsService.update(JSON.stringify(posts)).then((success) => {                    
                    return this.navigator.navigate(ReadViewControl, {
                        params: {
                            id: (posts.length + 1)
                        },
                        
                        replace: true
                    });
                }, (err) => {
                    console.warn(err);
                });
                
                return true;
            });
            
            event.stopPropagation();
        }, true);
    }
}

register.viewControl('create-vc', CreateViewControl, [PostsRepository, PostsService, ReadViewControl]);
