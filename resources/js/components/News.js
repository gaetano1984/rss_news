import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import {NewsTable} from './NewsTable';

export default class News extends Component {
    constructor(props) {
        super(props);
        this.state = {
            news: []
            ,sources: []
        };
    }
    componentDidMount(){
        this.updateNews();
        this.interval = setInterval(() => this.updateNews(), 10000);
        fetch('http://latestnews.local/api/getsources')
        .then(res => res.json())
        .then((result) => {
            this.setState({sources: result})
        });
    }
    updateNews(source = []){
        console.log(source);
        let data = JSON.stringify({
            source: source
        });
        fetch('http://latestnews.local/api/latest', 
            {
                method:'post', 
                headers: { 'Content-type': 'application/x-www-form-urlencoded' },
                body: data
            }
        )
        .then(res => res.json())
        .then((result) => {
            this.setState({news: result});
        });
    }
    handleChange(event){
        this.setState({sources: [event.target.value]});
    }

    render() {
        return (
            <div>
                <div>
                    Latest News
                    <table>
                        <tbody>
                            <tr>
                                <td>                   
                                    <select className="form-control" onChange={() => this.handleChange.bind(this)}>                 
                                    {this.state.sources.map((s) => (
                                        <option key={s.source} value={s.source}>{s.source}</option>
                                    ))}
                                    </select>
                                </td>
                            </tr>
                        </tbody>    
                    </table>
                    <NewsTable news={this.state.news} sources={this.state.sources} />
                </div>
            </div>
        );
    }
}

if (document.getElementById('latestnews')) {
    ReactDOM.render(<News />, document.getElementById('latestnews')); 
}