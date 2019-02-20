import React, { PureComponent } from 'react';


export default class NewsList extends PureComponent {
    render() {
        return <div>
                    <div class="bg-light py-4"  >
                        <div class=" text-white h5 bg-warning  mx-4   py-3 px-4">
                                    Žiadne ďalšie zápasy nie sú naplánované
                        </div>
                    </div>
                    <div class="my-3 mx-5 border-bottom" >
                        <p class="display-2 font-weight-light">Novinky</p>
                    </div> 
                </div>;
    }
}