import React, { PureComponent } from 'react';
import { View, Text, StyleSheet, AsyncStorage, TouchableOpacity } from 'react-native';
import { Header } from 'react-native-elements';
import { Left, Right} from 'native-base';
import { ActivityIndicator, FlatList } from 'react-native';
import { CheckBox, TextInput, Button } from 'react-native';
import Icon from 'react-native-vector-icons/FontAwesome';
import Pagination from 'react-native-pagination';
import {List, ListItem, SearchBar} from "react-native-elements";
//import { DataTable, DataTableCell, DataTableRow, DataTablePagination } from 'material-bread';
import { DataTable } from 'react-native-paper';

import { data } from './define';
const server = data[0];

export default class TabOrderAll extends PureComponent<Props> {
      static navigationOptions = {
           title: 'Quản lý đơn hàng',
           headerStyle: {
             color: '#DB4437'
           },
           headerTintColor: '#DB4437',
           headerTitleStyle: {
              fontWeight: 'bold',
           },
      };

    constructor(props) {
         super(props);
         this.state = {
           loading: false,
           page: 1,
           perPage: 50,
           totalRow: 0,
           dataApi: [],
           isLoading: true,
           username: "",
           date:  new Date().getSeconds(),
           isSelected: false,
           refreshing: false
         };
    }

    componentDidMount() { //auto run function
            //console.log('method: ', this.props.method); // Get method
           // get session
           AsyncStorage.getItem('accountshopping', (err, result) => {

                       //console.log(result);
                        //console.log('page: ', this.state.page);
                       this.setState({loading: true});
                       fetch(server+'orderApi.html', {
                               method: 'POST',
                               headers: {
                                 Accept: 'application/json',
                                 'Content-Type': 'application/json',
                               },
                               body: JSON.stringify({
                                  account_idx: JSON.parse(result).account_idx,
                                  account_ID: JSON.parse(result).account_ID,
                                  account_role: JSON.parse(result).account_role,
                                  method: this.props.method,
                                  page : this.state.page,
                                  datasearch : []
                               }),
                             })
                        .then((response) => response.json())
                        .then((responseJson) => {
                            //console.log(responseJson);
                            if (responseJson.result) {
                                 //console.log(responseJson.list_order);

                                 this.setState({dataApi: this.state.page === 1 ? responseJson.list_order.data : [...this.state.dataApi, ...responseJson.list_order.data], totalRow: responseJson.list_order.count, loading: false,  refreshing: false });
                            }
                        })
                        .catch((error) => this.setState({loading: false}))
                        .finally(() => {
                             this.setState({ isLoading: false });
                        });
           });
     }

     submitSearch(event) {
          this.setState({date: new Date().getSeconds()});
     }

    handleRefresh = () => {
        this.setState(
            {
                page: 1,
                refreshing: true
            },
            () => {
                this.componentDidMount();
            }
        );
    };

     handleLoadMore = () => {
         if (Math.floor(this.state.totalRow / this.state.perPage) > this.state.page ) {
             this.setState(
                 {
                     page: this.state.page + 1
                 },
                 () => {
                     this.componentDidMount();
                 }
             );
         }
     };

     renderSeparator = () => {
         return (
             <View
                 style={{
                     height: 1,
                     width: "86%",
                     backgroundColor: "#CED0CE",
                     marginLeft: "14%"
                 }}
             />
         );
     };

     renderFooter = () => {
         if (!this.state.loading) return null;

         return (
             <View
                 style={{
                     paddingVertical: 20,
                     borderTopWidth: 1,
                     borderColor: "#CED0CE"
                 }}
             >
                 <ActivityIndicator animating size="large"/>
             </View>
         );
     };

    FlatListItemSeparator =()=> {
        return (
          <View
            style={{
              height: 1,
              width: "100%",
              backgroundColor: "#607D8B",
            }}
          />
        );
      }

    render () {
        const { navigation } = this.props;

        return (
            <View style={styles.container}>
                <View style={{ borderColor: '#ccc', backgroundColor: 'rgb(217, 217, 217)', borderWidth: 1 }}>
                    <View style={{height:50,  paddingTop:15, left: 20}}>
                       <View style={{flex: 1, flexDirection: 'row'}}>
                           <View style={{width: '79%'}} >
                               <TouchableOpacity activeOpacity={0.95}>
                                  <TextInput style={{borderWidth: 0.5, borderColor: '#607D8B', backgroundColor: '#fff'}} value={this.state.searchtext}
                                       onChangeText={searchtext =>
                                           this.setState({ searchtext })
                                       }
                                       ref={input => {
                                           this.textInput = input;
                                       }}  placeholder="홍길동 (name)"/>
                               </TouchableOpacity>
                           </View>
                       </View>
                    </View>
                    <View style={{height:50,  paddingTop:10, left: 20}}>
                       <View style={{flex: 1, flexDirection: 'row'}}>
                           <View style={{width: '79%', bottom: 5}} >
                               <TouchableOpacity activeOpacity={0.95}>
                                  <TextInput style={{borderWidth: 0.5, borderColor: '#607D8B', backgroundColor: '#fff'}} value={this.state.searchtext}
                                       onChangeText={searchtext =>
                                           this.setState({ searchtext })
                                       }
                                       ref={input => {
                                           this.textInput = input;
                                       }}  placeholder="홍길동 (name)"/>
                               </TouchableOpacity>
                           </View>
                       </View>
                    </View>
                </View>
                <View style={{width: '12%',  position: 'absolute', right: 70, top: 25}}>
                    <Icon.Button style={{ backgroundColor: '#DB4437', height: 30}}
                       name='search'
                        onPress={this.submitSearch.bind(this)}
                    >
                    </Icon.Button>
                </View>
                {this.state.isLoading ? <ActivityIndicator size = "large"/> : (
                     <FlatList
                          data={this.state.dataApi}
                          keyExtractor={({ id }, index) => id}
                          renderItem={({ item, index }) => (

                          <View style= {styles.contentOrder}>
                              <View style={{flex: 1, flexDirection: 'row'}}>
                                 <View style={styles.contentOrderLeft}>
                                    <View>
                                        <Text style={styles.textPurcharse}>
                                        {item.statusTicket == -1? 'Hết hiệu lực' : item.statusTicket == 1? 'Mua xong'
                                            : item.statusTicket == 2? 'Đã sử dụng' : item.statusTicket == 3? 'Hết hạn sử dung'
                                            : item.statusTicket == 4? 'Hoàn tiền' : 'Hết hạn hoàn tiền'}
                                        </Text>
                                    </View>
                                    <View style={{ padding: '20%'}}>
                                        <CheckBox
                                          value={this.state.isSelected}

                                          style={styles.checkbox}
                                        />
                                    </View>
                                 </View>
                                 <View style={styles.contentOrderRight}>
                                    <Text style={styles.textbold}>T-Bridge: {item.ticketNumber}</Text>
                                    <Text style={styles.textbold}>Gmarket: {item.travelProductId}</Text>
                                    <View style={{marginTop: 10}}>
                                        <Text> {item.dealName} {this.state.date}</Text>
                                        <Text> {item.price}M [{item.name}]</Text>
                                        <Text> {item.userName} [{item.phoneNumber}]</Text>
                                        <Text> Ngày mua: [{item.purchaseDateTime}]</Text>
                                    </View>
                                 </View>
                              </View>
                        </View>
                    )}

                    ItemSeparatorComponent={this.renderSeparator}
                    ListFooterComponent={this.renderFooter}
                    onRefresh={this.handleRefresh}
                    refreshing={this.state.refreshing}
                    onEndReached={this.handleLoadMore}
                    onEndReachedThreshold={50}
                 />

             )}

            </View>
        );
    }
}

const styles = StyleSheet.create({
   container: { flex: 1, padding: 10, backgroundColor: '#fff' },
   textbold: {fontWeight: 'bold'},
   textPurcharse: {width: '70%', color: '#fff', backgroundColor: '#3b5998'},
   contentOrder: {borderColor: '#ccc', borderWidth: 1, marginTop: 10, padding: 10 },
   contentOrderLeft: {width: '30%'},
   contentOrderRight: {width: '70%', left: 15 },
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
    containerMarginTop: {
      marginTop: 30
    },
    footerStyle:
      {
        padding: 7,
        alignItems: 'center',
        justifyContent: 'center',
        borderTopWidth: 2,
        borderColor: '#607D8B'
      },

      TouchableOpacity_style:
      {
        padding: 7,
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#F44336',
        borderRadius: 5,
      },

      TouchableOpacity_Inside_Text:
      {
        textAlign: 'center',
        color: '#fff',
        fontSize: 18
      },

      flatList_items:
      {
        fontSize: 20,
        color: '#000',
        padding: 10
      }

});
/*
 initialNumToRender={50}
                    maxToRenderPerBatch={8}
                    onEndReachedThreshold={4}
*/
//ListFooterComponent = { this.Render_Footer }
//<DataTable style={{backgroundColor: 'rgb(217, 217, 217)'}}>
//                  <DataTable.Pagination
//                    page={this.state.page}
//                    numberOfPages={Math.floor(this.state.totalRow / this.state.perPage)}
//                    onPageChange={page => this.loadMoreOrderAPI(page)}
//                    label={`${this.state.page * this.state.perPage}-${(this.state.page +1) * this.state.perPage} of ${this.state.totalRow}`}
//                  />
//                </DataTable>