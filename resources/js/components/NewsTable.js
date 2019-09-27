import React, { Component } from 'react';
//import ReactDOM from 'react-dom';

export class NewsTable extends Component {
    constructor(props){
        super(props);
    }
    formatDate(d){
        d = new Date(d);
        d.setHours(d.getHours()+2);
        let min = d.getMinutes();
        min = min<10 ? '0'+min : min;
        let hour = d.getHours()+':'+min;
        let s = hour;
        return s;
    }
    render(){
        return (
            <table className="table table-stripe" border="1">
                <thead>
                    <tr>
                        <th>date</th>
                        <th>title</th>
                        <th>source</th>
                    </tr>
                </thead>
                <tbody>
                    {this.props.news.map((n) => (
                        <tr key={n.id}>
                            <td>{this.formatDate(n.news_date)}</td>
                            <td><a href={n.guid}>{n.title}</a></td>
                            <td>{n.source}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        );
    }
}

export default NewsTable;