import React, { PureComponent } from 'react';
import { View, Text, StyleSheet, ScrollView, AsyncStorage, TouchableOpacity } from 'react-native';
import { Header } from 'react-native-elements';
import { Left, Right} from 'native-base';
import { ActivityIndicator, FlatList } from 'react-native';
//import Pagination from 'react-native-pagination';
import {List, ListItem, SearchBar} from "react-native-elements";
import { DataTable } from 'react-native-paper';

import { data } from './define';
const server = data[0];

const styles = StyleSheet.create({
    scene: {flex: 1,},
    stypeScroll: { flex: 1, padding: 10, backgroundColor: '#fff' },
    container: { flex: 1, alignItems: "center" },
    mainItem: { width: '95%', height: 100, borderWidth: 1, borderColor: '#ccc', marginTop: 10, justifyContent: "center", alignItems: "center" },
    titleTop:{position: 'absolute', top:0, left:0, width: '25%',height: 25, backgroundColor: '#376092', justifyContent: "center", alignItems: "center"},
    content:{ position: 'absolute',  marginTop:5, left:10, top:30, width: '90%', alignItems: "flex-start" },
    buttonItem:{position: 'absolute', right:10, bottom:10, width: 50,height: 30, borderWidth: 1, borderColor: '#ccc', backgroundColor: '#ffffff', justifyContent: "center", alignItems: "center"},
    buttonPagination: {
           fontSize: 12,
           backgroundColor: 'rgb(217, 217, 217)',
           marginLeft: 5,
           width: '9%',
           height: 30,
           borderColor: '#000',
           borderWidth: 0.5,
           alignItems: 'center',
           justifyContent: 'center'
       },
       buttonPaginationActive: {
              fontSize: 12,
              backgroundColor: '#DB4437',
              marginLeft: 5,
              width: '9%',
              height: 30,
              borderColor: '#000',
              borderWidth: 0.5,
              alignItems: 'center',
              justifyContent: 'center'
          },
       pagination: {
           backgroundColor: 'rgba(0,0,0,0)',
           width: 400,
           position: 'absolute',
           right: 0,
           left: 0,
           bottom: 7,
           padding: 0,
           flex: 1,
           justifyContent: 'center',
           alignItems: 'center',
           flexDirection: 'row'
       },
});
export default class TabQuestion extends PureComponent {
    constructor(props) {
        super(props);
        this.state = {
           loading: false,
           page: 1,
           perPage: 50,
           totalRow: 0,
           data: [],
           isLoading: true,
           username: "",
           refreshing: false,
        };
        this.loadPagination = this.loadPagination.bind();
        this.loadMoreQuestionAPI = this.loadMoreQuestionAPI.bind();
    }
    componentDidMount() {
        //console.log('method: ', this.props.method); // Get method
        AsyncStorage.getItem('accountshopping', (err, result) => {
          var account = result;
          fetch(server+'questionchannelApi.html', {
               method: 'POST',
               headers: {
                 Accept: 'application/json',
                 'Content-Type': 'application/json',
               },
               body: JSON.stringify({
                    account_idx: JSON.parse(result).account_idx,
                    account_ID: JSON.parse(result).account_ID,
                    account_role: JSON.parse(result).account_role,
                    channel_name: this.props.method,
                    method: 'unreply',
                    page : this.state.page,
               })
          })
          .then((response) => response.json())
          .then((responseJson) => {
            if (responseJson.result) {
                this.setState({ data: responseJson.list_question.data });
                this.setState({ count: responseJson.list_question.count });
                this.setState({ msg: responseJson.msg });
                this.setState({totalRow: responseJson.list_question.count});
            }
          })
          .catch((error) => {
                this.setState({loading: false})
//              console.log(error);
//              console.error(error);
          })
          .finally(() => {
               this.setState({ isLoading: false });
          });
        });
    }

    loadMoreQuestionAPI = (page) => {
         this.setState(
             {
                 page: page
             },
             () => {
                 this.componentDidMount();
             }
         );
    };

    loadPagination = () => {
            let totalPage = Math.ceil(this.state.totalRow / this.state.perPage);
            let dataPagination = [];
            let dataPaginationPre = [];
            let dataPaginationNext = [];
            // getPrePage

            if (this.state.page != 1) {
                dataPaginationPre.push(this.state.page -1);
            }

            // getNextPage
            if (this.state.page < totalPage) {
                dataPaginationNext.push(this.state.page + 1);
            }
            for (let i = this.state.page; i <= ((this.state.page + 4) > totalPage ? totalPage : (this.state.page + 4)); i += 1) {
                dataPagination.push(i);
            }

            return (
               <View style={{flex: 1, flexDirection: 'row'}}>
                {

                    dataPaginationPre.map((item, index) => <View key={index} style={this.state.page == item ? styles.buttonPaginationActive : styles.buttonPagination} >
                                                    <TouchableOpacity activeOpacity={0.95} onPress={() => this.loadMoreQuestionAPI(item)} >
                                                        <Text > {"<"} </Text>
                                                    </TouchableOpacity>
                                                 </View>
                                         )
                }

                {

                  dataPagination.map((item, index) => <View key={index} style={this.state.page == item ? styles.buttonPaginationActive : styles.buttonPagination} >
                                                <TouchableOpacity activeOpacity={0.95} onPress={() => this.loadMoreQuestionAPI(item)} >
                                                    <Text >{item}</Text>
                                                </TouchableOpacity>
                                             </View>
                                     )
                }

                {

                    dataPaginationNext.map((item, index) => <View key={index} style={this.state.page == item ? styles.buttonPaginationActive : styles.buttonPagination} >
                                                    <TouchableOpacity activeOpacity={0.95} onPress={() => this.loadMoreQuestionAPI(item)} >
                                                        <Text > {">"} </Text>
                                                    </TouchableOpacity>
                                                 </View>
                                         )
                }
                </View>
            )
       };
    render () {
        const { navigation } = this.props;
        console.log(this.state.page);
        return (
            <View>
                <View style={{height:50,  paddingTop:25, left: 15}}><Text>총 {this.state.count}</Text></View>

                {this.state.isLoading ? <ActivityIndicator size = "large"/> : (
                     <FlatList
                          data={this.state.data}
                          keyExtractor={({ id }, index) => id}
                          renderItem={({ item, index }) => (
                          <View style={styles.container}>
                              <View style={styles.mainItem}>
                                  <View style={styles.titleTop}>
                                      <Text style={{color: '#fff'}}>{item.channel_name}</Text>
                                  </View>
                                  <View style={styles.content}>
                                      <Text style={{color: '#000'}}>{item.question_name}</Text>
                                      <Text style={{color: '#ccc', position: 'absolute', left: 70}}>{item.question_created}</Text>
                                      <Text style={{color: '#000', marginTop:5}}>질문~~~테스트~</Text>
                                  </View>
                                  <View style={styles.buttonItem}>
                                      <Text style={{color: '#DB4437'}}>답변</Text>
                                  </View>
                              </View>
                          </View>
                    )}
                     />
                )}
                <View style={{ width: '100%', height: 35, marginTop:10,  alignItems: 'center', justifyContent: 'center'}}>
                      {this.loadPagination()}
                </View>
            </View>
        );
    };
}
