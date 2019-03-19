import React, { PureComponent } from 'react';


export default class UpcomingMatches extends PureComponent {
    render() {
            return <div>
                     <div className="bg-light">
                        <div className=" text-secondary border-bottom mx-5 py-3 ">
                                    <h2 className="font-weight-normal">Najbližšie zápasy</h2>
                        </div>
                    </div>
                    <div className="bg-light py-4"  >
                        <div className=" text-white h5 bg-warning  mx-4   py-3 px-4">
                             Žiadne ďalšie zápasy nie sú naplánované
                         </div>
                    </div>
                </div>;
    }
}