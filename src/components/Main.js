import React, { Component } from 'react';
import { ActivityIndicator, FlatList ,BackHandler, ToastAndroid, StyleSheet, ScrollView, AsyncStorage } from 'react-native';
import {Modal, TouchableHighlight, View, Text, TextInput, Button, TouchableOpacity, Dimensions, Linking, Image} from 'react-native';
import { WebView } from 'react-native-webview';
//import { Table, TableWrapper, Row } from 'react-native-table-component';
import { DataTable } from 'react-native-paper';
import Cookie from 'react-native-cookie'; //npm install react-native-cookie --save
import { LineChart } from 'react-native-chart-kit' // npm i react-native-chart-kit --save  // npm i react-native-svg --save
import Icon from 'react-native-vector-icons/FontAwesome';

import TabMainModal from './TabMainModal';
import { data } from './define';
const server = data[0];

let { height } = Dimensions.get('window');
let box_count = 3;
let box_height = height / box_count;
// line chart//////////////

const screenWidth = Dimensions.get('window').width;
const chartConfig = {
  backgroundGradientFrom: "#1E2923",
  backgroundGradientFromOpacity: 0.8,
  backgroundGradientTo: "#08130D",
  backgroundGradientToOpacity: 0.5,
  color: (opacity = 1) => `rgba(26, 255, 146, ${opacity})`,
  labelColor: (opacity = 1) => `rgba(26, 255, 146, ${opacity})`,
  strokeWidth: 3, // optional, default 3
  barPercentage: 10,
  useShadowColorFromDataset: false,// optional
  decimalPlaces: 0,
};
//////////////////

export default class Main extends Component {
  constructor(props) {
     super(props);
     this.state = {
       dataApi: [],
       tabModal: 0,
       isLoading: true,
       modalVisible: false,
       modalVisibleUse: false,
       notifications: [],
       textNotification: '',
       searchtext: "",
       username: "",
       account_idx : "aaa",
       account_ID : "aaa",
       account_role : "aaa",
       order_number: 0,
       question_number: 0,
       date: new Date().getDate() < 10 ? '0' + new Date().getDate() : new Date().getDate(),
       month: (new Date().getMonth() + 1) < 10 ? '0' + (new Date().getMonth() + 1) : (new Date().getMonth() + 1),
       min: new Date().getMinutes() < 10 ? '0' + new Date().getMinutes() : new Date().getMinutes(),
       hour: new Date().getHours() < 10 ? '0' +  new Date().getHours() : new Date().getHours()  ,
       dataChart1 : {
         labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
         datasets: [
                       {   data: [ 0, 0, 0, 0, 0, 0, 0 ] ,
                           color: (opacity = 1) => `rgba(91, 177, 217, ${opacity})`, // optional
                           strokeWidth: 3, // optional
                       },
                       {   data: [ 0, 0, 0, 0, 0, 0 ,0] ,
                           color: (opacity = 1) => `rgba(253, 209, 0, ${opacity})`, // optional
                           strokeWidth: 3 , // optional
                       },
                   ],
         legend: ["이번주" , '전주'] // optional
       },

       dataChart2 : {
         labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
         datasets: [
                       {   data: [ 0, 0, 0, 0, 0, 0 ,0] ,
                           color: (opacity = 1) => `rgba(91, 177, 217, ${opacity})`, // optional
                           strokeWidth: 3, // optional
                       },
                       {   data: [ 0, 0, 0, 0, 0, 0 ,0] ,
                           color: (opacity = 1) => `rgba(253, 209, 0, ${opacity})`, // optional
                           strokeWidth: 3 , // optional
                       },
                   ],
         legend: ["이번주" , '전주'] // optional
       }
     };

     this.logout = this.logout.bind();
     this.toggleModalUse = this.toggleModalUse.bind();
     this.handleBackButton =this.handleBackButton.bind();
     this.loadNotifications = this.loadNotifications.bind();
  }
  /////////////////////////////
  componentWillUnmount() {
      BackHandler.removeEventListener('hardwareBackPress', this.handleBackButton);
  }
  handleBackButton() {
      //ToastAndroid.show('Back button is pressed', ToastAndroid.SHORT);
      console.log('Back button is pressed ');
      return true;
  }
  componentDidMount() { //auto run function
        BackHandler.addEventListener('hardwareBackPress', this.handleBackButton);
       // get session
       AsyncStorage.getItem('accountshopping', (err, result) => {
              var account = result;
              //console.log(account);
                 var min = new Date().getMinutes(); //Current Minutes
               var sec = new Date().getSeconds(); //Current Seconds
              console.log('t1:   ', min + ':' + sec);
              fetch(server+'dashboardApi.html', {
                   method: 'POST',
                   headers: {
                     Accept: 'application/json',
                     'Content-Type': 'application/json',
                   },
                   body: JSON.stringify({
                      account_idx: JSON.parse(result).account_idx,
                      account_ID: JSON.parse(result).account_ID,
                      account_role: JSON.parse(result).account_role
                   })
              })
              .then((response) => response.json())
              .then((responseJson) => {
                   //console.log(responseJson);
                  if (responseJson.result) {

                      this.state.notifications= responseJson.notifications;
                      this.state.company_name= responseJson.company_name;
                      this.state.order_number= responseJson.order_number;
                      this.state.question_number= responseJson.question_number;

                      this.state.homqua_show= responseJson.homqua_show;
                      this.state.homnay_show= responseJson.homnay_show;
                      this.state.amountsoldrealtotal_homqua= responseJson.amountsoldrealtotal_homqua;
                      this.state.amountsoldrealtotal_homnay= responseJson.amountsoldrealtotal_homnay;
                      this.state.amountsoldusetotal_homqua= responseJson.amountsoldusetotal_homqua;
                      this.state.amountsoldusetotal_homnay= responseJson.amountsoldusetotal_homnay;
                      this.state.tong_muaxong_homqua= responseJson.tong_muaxong_homqua;
                      this.state.tong_muaxong_homnay= responseJson.tong_muaxong_homnay;
                      this.state.tong_sudung_homqua= responseJson.tong_sudung_homqua;
                      this.state.tong_sudung_homnay= responseJson.tong_sudung_homnay;
                        var dates = [];
                        var timeFrom = (X) => {
                            for (let I = Math.abs(X)-1; I >= 0; I--) {
                                let date= new Date(new Date().getTime() - ((X >= 0 ? I : (I - I - I)) * 24 * 60 * 60 * 1000));
                                dates.push((date.getMonth()+1)+"/"+date.getDate());
                            }
                            return dates;
                        }
                       dates=timeFrom(7); // Past 7 Days
                       this.state.dataChart1.labels=dates;
                       this.state.dataChart2.labels=dates;
                       this.state.dataChart1.datasets[0].data=responseJson.data11;
                       this.state.dataChart1.datasets[1].data=responseJson.data22;
                       this.state.dataChart2.datasets[0].data=responseJson.data33;
                       this.state.dataChart2.datasets[1].data=responseJson.data44;

                  }
              })
              .catch((error) => {
                      console.log(error);
                      console.error(error);
                   })
              .finally(() => {
                    var min = new Date().getMinutes(); //Current Minutes
                    var sec = new Date().getSeconds(); //Current Seconds
                    console.log('t2:  ', min + ':' + sec);
                    this.setState({ isLoading: false });
              });

       });
       //AsyncStorage.removeItem(SESSION_KEY);
  }

  logout = () => {
        AsyncStorage.removeItem('accountshopping');
        this.props.navigation.navigate('Login');
  }

  submitRefresh = () => {
    this.setState({isLoading : true});
     this.componentDidMount();
  }
  toggleModalTab1(visible) {
      this.setState({tabModal : 0});
      this.setState({modalVisible: !this.state.modalVisible});
  }

  toggleModalTab2(visible) {
     this.setState({tabModal : 1});
     this.setState({modalVisible: !this.state.modalVisible});
  }

  toggleModalUse = (item) => {
    console.log('item' , item);
    this.setState({textNotification: item});
    this.setState({modalVisibleUse: !this.state.modalVisibleUse});
  }

  closeModalTab(visible) {
     this.setState({ modalVisible: visible });
  };

  closeModalUse(visible) {
     this.setState({ modalVisibleUse: visible });
  };

  loadNotifications = () => {
       return (
            <View>
             {
                    this.state.notifications.map((item, index) => <View key={index}>
                                                  <TouchableOpacity activeOpacity={0.95}  onPress={() => { this.toggleModalUse(item);}} >
                                                      <Text>{item.notification_created} {item.notification_title}</Text>
                                                  </TouchableOpacity>
                                              </View>
                    )
            }
             </View>
       )
  };

  render() {
     const { navigation } = this.props;
     const searchSubmit = () => {
          //alert(this.state.searchtext);
          navigation.navigate('Order', { searchTextOrder : this.state.searchtext });
          //navigation.navigate('TabOrderAll', { searchtext : this.state.searchtext });
        //alert(this.state.searchtext);
//        fetch(server+'orderApi.html')
//           .then((response) => response.json())
//           .then((responseJson) => {
//               if (responseJson.result) {
//                    console.log(responseJson.list_order);
//                    this.setState({ dataApi: responseJson.list_order });
//               }
//           })
//           .catch((error) => console.error(error))
//           .finally(() => {
//                this.setState({ isLoading: false });
//           });
     };

    return (
    <View style={styles.container}>
        <ScrollView  style={{padding: 5}}>
                <View style={{width: '100%', borderColor: '#000', borderWidth: 1, borderRadius: 5}}>
                    <View style={{height:50, borderBottom: "#ccc", borderBottomWidth: 1, paddingTop:15}}>
                       <View style={{flex: 1, flexDirection: 'row'}}>
                           <View style={{width: '30%', left: 5, top: -5}} >
                               <Image source={require('../../assets/logo_c.jpg')} style={{ height: 28, width: 101 }} />
                           </View>
                           <View style={{width: '65%', bottom: 5}} >
                               <TouchableOpacity activeOpacity={0.95}>
                                  <TextInput style={{borderColor: '#ccc', borderWidth: 1, paddingLeft: 2}} value={this.state.searchtext}
                                       onChangeText={searchtext =>
                                           this.setState({ searchtext })
                                       }
                                       ref={input => {
                                           this.textInput = input;
                                       }}  placeholder="이름/전화번호/티켓번호 검색"/>
                               </TouchableOpacity>
                           </View>
                       </View>
                    </View>
                    <View style={{height:50, borderBottom: "#ccc", borderBottomWidth: 1, paddingTop:10}}>
                       <View style={{flex: 1, flexDirection: 'row'}}>
                           <View style={{width: '30%'}} >
                               <Text style={{left: 10}}>{this.state.company_name} </Text>
                           </View>
                          <View style={{flex: 1, flexDirection: 'row-reverse'}}>
                                <View style={{marginRight: 5}}>
                                   <Image source={require('../../assets/refresh.png')} style={{ height: 15, width: 15, top: 4 }} />
                               </View>
                               <View style={{marginRight: 5}} >
                                  <TouchableOpacity activeOpacity={0.95} onPress = {this.submitRefresh.bind(this)}>
                                    {this.state.isLoading ? <ActivityIndicator size = "large"/> : (
                                     <Text style={{color: 'rgb(0, 0, 238)', fontSize: 18, fontWeight: 'bold'}}>{this.state.month}월{this.state.date}일 {this.state.hour}시{this.state.min}분</Text>
                                    )}
                                   </TouchableOpacity>
                               </View>
                            </View>
                       </View>
                    </View>

                    <View style= {{ alignItems: 'center', color: '#CCC' , height : 100 , marginTop: 10 }}>
                        <View style={{flex: 1, flexDirection: 'row'}}>
                            <View style={styles.textContentResult} >
                                <TouchableOpacity activeOpacity={0.95}
                                    onPress={() => {navigation.navigate('Order', { route : 1 });}} >
                                    {this.state.isLoading ? <ActivityIndicator size = "large"/> : (
                                    <Text style={styles.textResult}>{this.state.order_number} 건</Text>
                                    )}
                                    <Text style={{ fontWeight: 'bold'}}>미사용 티켓 수량</Text>
                                </TouchableOpacity>
                            </View>
                            <View style={styles.textContentResult} >
                                <TouchableOpacity activeOpacity={0.95} onPress={() => {navigation.navigate('Question', { id: 120 });}} >
                                    <Text style={styles.textResult}>{this.state.question_number} 건</Text>
                                    <Text style={{ fontWeight: 'bold'  }}>미답변 문의 수</Text>
                                </TouchableOpacity>
                            </View>
                        </View>
                    </View>

                    <View style= {{  color: '#CCC', margin: 10 }}>
                        <Text style={{fontSize: 16, fontWeight: 'bold', alignItems: 'center' }}>판매현황</Text>
                    </View>
                    <View style={{ height: 1, width: '100%', borderRadius: 1, borderWidth: 0.5, borderColor: '#000' }}></View>
                                  <View style= {{  color: '#CCC' , height : 150, marginTop: 10 }}>
                                      <View style={{flex: 1, flexDirection: 'row'}}>
                                         <View style={[styles.boxTicket, styles.boxTicket3]}></View>
                                         <View style={[styles.boxTicket5, styles.boxTicket4]}><Text>어제 {this.state.homqua_show}</Text></View>
                                         <View style={[styles.boxTicket5, styles.boxTicket4]}><Text>오늘 {this.state.homnay_show}</Text></View>
                                      </View>
                                      <View style={{flex: 1, flexDirection: 'row'}}>
                                          <View style={[styles.boxTicket, styles.boxTicket1]}><Text>실판매금액</Text></View>
                                          <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{this.state.amountsoldrealtotal_homqua}</Text></View>
                                          <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{this.state.amountsoldrealtotal_homnay}</Text></View>
                                      </View>
                                      <View style={{flex: 1, flexDirection: 'row'}}>
                                        <View style={[styles.boxTicket, styles.boxTicket1]}><Text>사용처리금액</Text></View>
                                        <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{this.state.amountsoldusetotal_homqua}</Text></View>
                                        <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{this.state.amountsoldusetotal_homnay}</Text></View>
                                      </View>
                                      <View style={{flex: 1, flexDirection: 'row'}}>
                                        <View style={[styles.boxTicket, styles.boxTicket1]}><Text>판매티켓수</Text></View>
                                        <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{this.state.tong_muaxong_homqua}</Text></View>
                                        <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{this.state.tong_muaxong_homnay}</Text></View>
                                      </View>
                                      <View style={{flex: 1, flexDirection: 'row'}}>
                                          <View style={[styles.boxTicket, styles.boxTicket1]}><Text>사용완료티켓수</Text></View>
                                          <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{this.state.tong_sudung_homqua}</Text></View>
                                          <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{this.state.tong_sudung_homnay}</Text></View>
                                      </View>
                                </View>

                     <View style= {{padding: 10, width: '100%', alignItems: 'center', justifyContent: 'center', color: '#CCC'}}>
                            <TouchableOpacity activeOpacity={0.95} style={styles.button} onPress={() => {navigation.navigate('Order');}} >
                                <Text style={styles.text}>주문내역 전체보기 > </Text>
                            </TouchableOpacity>
                      </View>
                     <View style= {{  color: '#CCC' }}>
                         <Text style={{fontSize: 16, fontWeight: 'bold', alignItems: 'center' }}>주간 구매수량 추이</Text>
                     </View>
                    <View style= {{padding: 10, width: '100%', alignItems: 'center', justifyContent: 'center', color: '#CCC'}}>
                       <LineChart
                         data={this.state.dataChart1}
                         width={screenWidth-20}
                         height={220}
                         chartConfig={chartConfig}
                       />
                    </View>
                    <View style= {{  color: '#CCC', marginTop: 15 }}>
                         <Text style={{fontSize: 16, fontWeight: 'bold', alignItems: 'center' }}>주간 이용수량 추이</Text>
                     </View>
                    <View style= {{padding: 10, width: '100%', alignItems: 'center', justifyContent: 'center', color: '#CCC'}}>
                       <LineChart
                         data={this.state.dataChart2}
                         width={screenWidth-20}
                         height={220}
                         chartConfig={chartConfig}
                       />
                    </View>

                    <View style={{width: 45,  position: 'absolute', right: 5, top: 10}}>
                        <Icon.Button style={{ backgroundColor: '#DB4437', height: 30}}
                           name='search'
                           onPress={searchSubmit}
                        >
                        </Icon.Button>
                    </View>
                </View>
                <View style={{width: '100%', top: 10, padding: 10, borderColor: '#000', borderWidth: 0.8}}>
                    <View style={{bottom: 10}}>
                        <Text style={{fontSize: 18, fontWeight: 'bold',paddingTop: 5}}>공고</Text>
                    </View>
                    {this.loadNotifications()}
                </View>

                <View style= {{padding: 10, width: '100%', alignItems: 'center', justifyContent: 'center', color: '#CCC', top: 10, height: 180}}>
                    <View style={styles.buttonPolicies}>
                        <Text>티브리지(주)  대표이사 : 000</Text>
                        <Text>사업자 등록번호 000-00-00000</Text>
                        <Text>서울시 000 00000</Text>
                    </View>
                    <View style={{flex: 1, flexDirection: 'row'}}>
                          <View style={{width: 70, height: 30,  backgroundColor: '#fff', alignItems: 'center', justifyContent: 'center', marginRight: 10}} >
                                <TouchableOpacity activeOpacity={0.95}  onPress = {this.toggleModalTab1.bind(this)} >
                                    <Text style={styles.contentStyleColor}>이용약관</Text>
                               </TouchableOpacity>
                          </View>
                          <View style={{width: 120, height: 30, backgroundColor: '#fff', marginRight: 5, alignItems: 'center', justifyContent: 'center'}} >
                              <TouchableOpacity activeOpacity={0.95}  onPress = {this.toggleModalTab2.bind(this)}>
                                  <Text style={styles.contentStyleColor}> 개인정보 처리 방침</Text>
                             </TouchableOpacity>

                          </View>
                    </View>
                </View>
                <Modal
                    animationType="slide"
                    transparent={true}
                    visible={this.state.modalVisibleUse}
                    onRequestClose={() => {
                      Alert.alert("Modal has been closed.");
                    }}
                  >
                    <View style={styles.centeredView}>
                      <View style={styles.modalView}>
                        <View style={{position: 'absolute', top: 4, alignItems: 'center', justifyContent: 'center', width: 50, height: 30, right: 20}}>
                             <TouchableHighlight onPress = {() => {
                                  this.closeModalUse(!this.state.modalVisibleUse)}}>
                                  <Text style = {{alignItems: 'center', justifyContent: 'center', color: '#6d6767ad', fontSize: 22}}>X </Text>
                             </TouchableHighlight>
                          </View>
                        <Text style={styles.modalText}>통지 참조</Text>
                        <View style={{borderColor: '#ccc', borderWidth: 0.8, height: 30, top: 10, justifyContent: 'center', paddingLeft: 10}}>
                            <Text>{this.state.textNotification.notification_created} {this.state.textNotification.notification_title}</Text>
                        </View>
                        <View style={{borderColor: '#ccc', borderWidth: 0.8, height: 'auto', top: 10, justifyContent: 'center', padding: 10, marginTop: 10}}>
                            <ScrollView>
                                <Text>{this.state.textNotification.notification_content}</Text>
                            </ScrollView>
                        </View>

                      </View>
                    </View>
                  </Modal>
            </ScrollView >
            <Modal animationType = {"slide"} transparent = {false}
                   visible = {this.state.modalVisible}
                   style={{width: '100%', backgroundColor: 'rgba(0,0,0,0.4)'}}
                   onRequestClose = {() => { console.log("Modal has been closed.") } }>

               <TabMainModal tabModal={this.state.tabModal}/>
               <View style={{position: 'absolute', top: 4, alignItems: 'center', justifyContent: 'center', width: 50, height: 30, right: 20}}>
                 <TouchableHighlight onPress = {() => {
                      this.closeModalTab(!this.state.modalVisible)}}>
                      <Text style = {{alignItems: 'center', justifyContent: 'center', color: '#6d6767ad', fontSize: 22}}>X </Text>
                 </TouchableHighlight>
              </View>
            </Modal>
            <View style= {{ width: '100%', position: 'absolute', bottom: 0, alignItems: 'center', justifyContent: 'center', backgroundColor: '#f2f2f2'}}>
            <View style={{flex: 1, flexDirection: 'row'}}>
                  <View style={{width: 70, height: 30, borderColor: '#a9a9a9', borderWidth: 1, backgroundColor: '#fff', alignItems: 'center', justifyContent: 'center', marginRight: 10}} >
                        <TouchableOpacity activeOpacity={0.95}  onPress = {this.logout.bind(this)} >
                            <Text style={styles.contentStyleColor}>로그아웃</Text>
                       </TouchableOpacity>
                  </View>
                  <View style={{width: 70, height: 30, borderColor: '#a9a9a9', borderWidth: 1, backgroundColor: '#fff', marginRight: 5, alignItems: 'center', justifyContent: 'center'}} >
                      <TouchableOpacity activeOpacity={0.95} onPress={() => Linking.openURL('http://tmobile.lavianspa.com/')} >
                          <Text style={styles.contentStyleColor}>PC버전</Text>
                     </TouchableOpacity>

                  </View>
            </View>
        </View>
    </View>
    );
  }

};

 const styles = StyleSheet.create({
  container: { flex: 1,  paddingTop: 30, backgroundColor: '#fff' },
  header: { height: 50, backgroundColor: '#537791' },
  dataWrapper: { marginTop: -1 },
  row: { height: 40, backgroundColor: '#E7E6E1' },
  centeredView: {
      flex: 1,
      justifyContent: "center",
      alignItems: "center",
      marginTop: 22
   },
  modalView: {
    width: 350,
    height: 'auto',
    margin: 20,
    backgroundColor: "white",
    borderRadius: 20,
    padding: 25,
    shadowColor: "#000",
    shadowOffset: {
      width: 0,
      height: 2
    },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
    elevation: 5
  },
   modalText: {
      marginBottom: 15,
      textAlign: "center",
      color: '#DB4437',
      fontSize: 20,
      fontWeight: 'bold'
    },
  boxTicket: {
          height: 30,
          width: '40%',
          paddingTop: 4,
          paddingLeft:2
      },
      boxTicket5: {
          height: 30,
          width: '30%',
          justifyContent: 'center',
          padding: 2
      },
      boxTicket1: {
          backgroundColor: '#ccc',
          borderColor: '#000',
          borderWidth: 0.5
      },
      boxTicket2: {
          borderColor: '#000',
          borderWidth: 0.5
      },
      boxTicket3: {
          backgroundColor: '#fff'
      },
      boxTicket4: {
      backgroundColor: '#CCC',
          borderColor: '#000',
          borderWidth: 0.5
      },
      parent: {
          width: 300,
          height: 500,
          backgroundColor: 'red',
          margin: 50,
      },
      button: {
          flexDirection: 'row',
          width: '100%',
          height: 50,
          alignItems: 'center',
          justifyContent: 'center',
          marginTop: 22,
          color: '#DB4437',
          borderColor: '#DB4437',
          borderWidth: 1,
          borderRadius: 10,
          textDecorationLine: 'none',
          bottom: 10
      },
      buttonPolicies: {
                height: 50,
                alignItems: 'center',
                justifyContent: 'center',
                marginTop: 30,
                textDecorationLine: 'none',
                bottom: 30
            },
      text: {
          color: '#DB4437',
          fontSize: 16,
          fontWeight: 'bold',
          padding: 80
      },
      textContentResult: {
          marginLeft: 8,
          width: '46%',
          height: 100,
          borderColor: '#000',
          borderWidth: 0.5,
          alignItems: 'center',
          justifyContent: 'center'
      },
      textResult: {
          fontSize: 18,
          fontWeight: 'bold',
          textDecorationLine: 'underline',
          textDecorationStyle: 'solid',
          textDecorationColor: '#000',
          paddingLeft : 25
      },
});
