import {register, ui} from 'platypus';
import PostsRepository from '../../repositories/posts/posts.repo';
import ReadViewControl from '../../viewcontrols/read/read.vc';


export default class ArticlelistTemplateControl extends ui.TemplateControl {
    templateString: string = require('./articlelist.tc.html');
    
    context: any = {
        readView: ReadViewControl
    };
    
    constructor(private postsRepository: PostsRepository) {
        super();
    }
}

register.control('articlelist', ArticlelistTemplateControl, [ReadViewControl]);
