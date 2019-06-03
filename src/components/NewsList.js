import React, { PureComponent } from 'react';
import providers from '../dataProvider';

export default class NewsList extends PureComponent {
    constructor(props){
        super(props);
        
        this.state = { list: [] };

      providers.getNewsList().then(data => {
          this.setState({ list: data.news });
      });
    }

    render() {
        return <div className="container mb-4">
                    <div className="border-bottom mt-2">
                        <h1 className="font-weight-light">Novinky</h1>
                    </div>  
                  {this.state.list.map((news,index) =>{
                    return(
                          <div className="card mt-4"  key={index}>
                              <h5 className="card-header font-italic mt-0">{news.title}</h5>
                              <div className="card-body"> 
                                <div className="card-text text-justify">{news.text}</div>
                            </div>
                          </div>
                        )
                    })}                
                 </div>
    }
}