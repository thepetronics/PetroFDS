import random, os
import win32ui, win32con, win32api, win32print, win32gui, traceback
from win32api import RGB
from texttable import Texttable
import tkinter as tk
from tkinter import ttk
from tkinter import messagebox
from tkinter import *
import json
import sqlite3
import tkinter.messagebox
import urllib.parse
try:
    import urllib.request as urllib2
except ImportError:
    import urllib2
import session as sess
from textwrap import wrap
import json
import re
import threading
import time
import webbrowser

H1_FONT = ("Times", 20, "bold")
TITLE_FONT = ("Times", 15, "bold")
CUSTOM_FONT = ("Arial", 10, "bold")
NORMAL_FONT = ("Arial", 7, "bold")
SMALL_FONT = ("Arial", 5, "bold")
SESSION_DIR = 'session/'
API_URL = 'http://thepetronics.com/fds/demoapp/api'

class Database:
    def __init__(self):
        conn = sqlite3.connect("PetroFDS.db")
        cursor = conn.cursor()
        cursor.execute("""CREATE TABLE IF NOT EXISTS session
                       (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, firstname TEXT, lastname TEXT)
                       """)
        cursor.execute("""CREATE TABLE IF NOT EXISTS settings
                       (id INTEGER PRIMARY KEY AUTOINCREMENT, time TEXT, footer_text TEXT)
                       """)
        cursor.execute("""CREATE TABLE IF NOT EXISTS orders
                       (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id TEXT, order_detail_id TEXT,
                       status TEXT, status_time TEXT, firstname TEXT, lastname TEXT, address_1 TEXT, address_2 TEXT,
                       city TEXT, post_code TEXT,loyalty_point TEXT, about_order TEXT, payment_method TEXT,
                       decline_reason TEXT, order_time TEXT, total_price TEXT, currency TEXT, order_date TEXT)
                       """)
        cursor.execute("""CREATE TABLE IF NOT EXISTS order_invoice
                       (id INTEGER PRIMARY KEY AUTOINCREMENT, order_detail_id TEXT, user_id TEXT,
                       quantity TEXT, price TEXT, name TEXT, currency TEXT, delivery_charges TEXT, price_all TEXT)
                       """)
        self.conn = conn

class PetroFDS(tkinter.Tk):

    def __init__(self, *args, **kwargs):
        tkinter.Tk.__init__(self, *args, **kwargs)
        self.geometry("1300x650")
        self.title('PetroFDS')
        self.configure(background="green")
        self.protocol("WM_DELETE_WINDOW", self.on_closing)

        container = ttk.Frame(self)
        container.pack(side="top", fill="both", expand=True)
        container.grid_rowconfigure(0, weight=1)
        container.grid_columnconfigure(0, weight=1)
        self.style = ttk.Style()
        self.frames = {}
        for F in (Login, Orders_ListView, PageTwo):
            frame = F(container, self)
            self.frames[F] = frame
            frame.grid(row=0, column=0, sticky="nsew")
        if(sess.ifSessionExist(SESSION_DIR)):
            self.show_frame(Orders_ListView)
        else:
            self.show_frame(Login)

    def Wiki(self,param):
        webbrowser.open('http://fds.thepetronics.com/Wiki/')

    def Webstie(self,param):
        webbrowser.open('http://fds.thepetronics.com/')

    def Report(self,param):
        webbrowser.open('http://fds.thepetronics.com/report/')

    def onExit(self):
        self.quit()

    def on_closing(self):
        if messagebox.askokcancel("Quit", "Are you Sure. Do you want to quit?"):
            self.destroy()
    
    def show_frame(self, c):
        frame = self.frames[c]
        frame.tkraise()


class Login(ttk.Frame):
        
    def log(self,controller):
        if len(self.usrname.get()) == 0:
            tkinter.messagebox.showwarning( "Error", "Please Enter Username.")
        elif len(self.password.get()) == 0:
            tkinter.messagebox.showwarning( "Error", "Please Enter Password.")
        elif len(self.sync.get()) == 0:
            tkinter.messagebox.showwarning( "Error", "Please Select Sync Time.")
        else:
            url = API_URL+"/login.php"
            data = {"username": self.usrname.get(),"password": self.password.get()}
            data = urllib.parse.urlencode(data)
            request = urllib2.Request(url + '?' + data)
            response = urllib2.urlopen(request)
            page = response.read().decode('utf-8')
            if page == '':
                tkinter.messagebox.showwarning( "Error", "Please Enter Correct Username or Password.")
            else:
                sess.createSession(SESSION_DIR,self.usrname.get(),page)
                json_obj = json.loads(page)
                db = Database()
                cursor = db.conn.cursor()
                sql_delete = """
                DELETE FROM session
                """
                cursor.execute(sql_delete)
                sql_insert = """
                INSERT INTO session VALUES (NULL,'"""+json_obj['username']+"""','"""+json_obj['firstname']+"""','"""+json_obj['lastname']+"""')
                """
                cursor.execute(sql_insert)
                db.conn.commit()
                self.run(controller)

    def run(self,controller):
        return controller.show_frame(Orders_ListView)

    def __init__(self, parent, controller):
        ttk.Frame.__init__(self, parent)
        self.loginstyle = ttk.Style()
        self.loginstyle.configure('Frm.TLabel', font=('Times', 12, 'bold'), foreground="black")
        sess.loadSessionDir(SESSION_DIR)
        self.lbl = ttk.Label(self, style="Frm.TLabel", text="Welcome to PetroFDS", font=TITLE_FONT)
        self.lbl.pack(pady=(5, 20))

        l = ttk.Label(self, style="Frm.TLabel", text="Login/Session Details")
        l.pack()
        frm = ttk.LabelFrame(self, labelwidget=l)
        frm.pack(expand=True, fill='x', anchor = "w", ipadx=10, ipady=5, padx=10, pady=0, side="top")
        
        self.lbl_username = ttk.Label(frm, text="Enter Your Username OR Email:-", font=CUSTOM_FONT)
        self.lbl_username.pack(pady=(30, 0))

        self.usrname = ttk.Entry(frm, width=40, font=CUSTOM_FONT)
        self.usrname.pack()
        
        self.lbl_password = ttk.Label(frm, text="Enter Your Password:-", font=CUSTOM_FONT)
        self.lbl_password.pack(pady=(25, 0))

        self.password = ttk.Entry(frm, width=40, show="*", font=CUSTOM_FONT)
        self.password.pack()

        self.lbl_sync = ttk.Label(frm, text="Select Sync Time:-", font=CUSTOM_FONT)
        self.lbl_sync.pack(pady=(25, 0))

        list = ['2', '4', '5', '10', '20', '30', '40', '50', '60', '80', '100', '120'];
        
        self.sync = ttk.Combobox(frm, width=15, values=list, font=CUSTOM_FONT)
        self.sync.pack()
        
        self.btn = ttk.Button(frm, text="Login", command=lambda: self.log(controller))
        self.btn.pack(pady=(25, 5))

        self.lbl = ttk.Label(self, text="© Copyright 2016-"+time.strftime("%Y")+". All Rights Reserved.ThePetronics(PetroFDS). Application Version 1.0 Developed By:ThePetronics.", font=TITLE_FONT)
        self.lbl.pack(pady=(5, 20))
    

class Orders_ListView(ttk.Frame):

    def __init__(self, parent, controller):
        ttk.Frame.__init__(self, parent)
        self.style = ttk.Style()
        self.style.configure('Treeview', rowheight=50)
        self.style.configure('My.TLabel', font=('Times', 8, 'bold'), justify='center', background='green', foreground='white')
        self.style.configure('My.TFrame', font=('Times', 8, 'bold'), justify='center', background='green')
        self.style.configure('Text.TLabel', font=('Times', 8, 'bold'), justify='center', background='green', foreground="white")
        self.style.configure('Mod.TLabelFrame.Label', font=('Times', 8, 'bold'), justify='center', background='green', foreground="white")
        self.style.configure('H1.TLabel', font=('Times', 12, 'bold'), justify='center', background='green', foreground="white")
        self.style.configure('Bt.TButton', font=('Times', 10, 'normal'), justify='center', background='green')
        self.lbl = ttk.Label(self, style="H1.TLabel", anchor=N, text='Orders List')
        self.lbl.pack(fill=BOTH)

        db = Database()
        cursor = db.conn.cursor()

        self.top = ttk.Frame(self,style="My.TFrame")
        self.bottom = ttk.Frame(self,style="My.TFrame")
        self.top.pack(side=TOP,fill=BOTH)
        self.bottom.pack(side=BOTTOM, fill=BOTH, expand=True)

        self.note = ttk.Label(self, anchor=N, text="Note: DoubleClick Or Press EnterKey on the Order to see Order Details", style='My.TLabel')
        self.note.pack(fill=BOTH)

        if(sess.ifSessionExist(SESSION_DIR)):
            login_name = 'Login as:- '+sess.getSession(SESSION_DIR,'firstname')+' '+sess.getSession(SESSION_DIR,'lastname')
            self.lbl = ttk.Label(self, style="Text.TLabel", text=login_name, font=CUSTOM_FONT)
            self.lbl.pack(in_=self.top, side=LEFT, padx=5, pady=5)

        self.btn = ttk.Button(self, style="Bt.TButton", text="Logout", command=lambda: self.logout(controller))
        self.btn.pack(in_=self.top, side=RIGHT, padx=5, pady=5)
        
        self.btn_setting = ttk.Button(self, style="Bt.TButton", text="Setting", command=lambda: self.Setting(controller))
        self.btn_setting.pack(in_=self.top, side=RIGHT, padx=5, pady=5)
      
        self.set_Col()

    def clean(self,raw_html):
        cleanr =re.compile('<.*?>')
        cleantext = re.sub(cleanr,'', raw_html)
        return cleantext

    def Setting(self,controller):
        self.setting = Toplevel()
        self.settingstyle = ttk.Style()
        self.setting.geometry("500x600")
        self.setting.title('Settings')
        self.setting.iconbitmap(r'favicon.ico')

        self.note = ttk.Label(self.setting, text="If you don't want to change one of the options given below then leave the field as it is.", foreground="red", font=NORMAL_FONT)
        self.note.pack(pady=(25, 0))

        db = Database()
        cursor = db.conn.cursor()

        self.lbl_sync = ttk.Label(self.setting, text="Enter Sync Time:-", font=CUSTOM_FONT)
        self.lbl_sync.pack(pady=(25, 0))

        self.lbl_sync = ttk.Label(self.setting, text="(Time are in Seconds)", font=SMALL_FONT)
        self.lbl_sync.pack(pady=(5, 0))

        self.sync = ttk.Entry(self.setting, width=15, font=CUSTOM_FONT)
        self.sync.pack(pady=(5, 0))

        self.footer_text_label = ttk.Label(self.setting, text="Footer Text", font=CUSTOM_FONT)
        self.footer_text_label.pack(pady=(5, 0))

        self.footer_text = Text(self.setting, width=50, font=CUSTOM_FONT)
        self.footer_text.pack(pady=(5, 0))

        sql = """
        SELECT * FROM settings
        """
        cursor.execute(sql)

        rows = cursor.fetchall()
        for row in rows:
            self.footer_text.insert(END,row[2])
            self.sync.insert(END,row[1])
        
        self.button = ttk.Button(self.setting, text="Edit", command=lambda: self.update_setting(self.sync.get(),self.footer_text.get('1.0',END)))
        self.button.pack(pady=(5, 0))

    def update_setting(self,sync,fot_text):
        db = Database()
        cursor = db.conn.cursor()
        try:
            if(sync!=''):
                sql_update = """
                UPDATE settings SET time="""+sync+"""
                """
                cursor.execute(sql_update)
                db.conn.commit()
            if(fot_text!=''):
                sql_update_setting = """
                UPDATE settings SET footer_text='"""+fot_text+"""'
                """
                cursor.execute(sql_update_setting)
                db.conn.commit()
            tkinter.messagebox.showinfo( "Done", "Changes Saved")
        except sqlite3.OperationalError as err:
            tkinter.messagebox.showerror( "Error", err)

            
    def logout(self,controller):
        sess.destroySessions(SESSION_DIR)
        db = Database()
        cursor = db.conn.cursor()
        sql_delete = """
        DELETE FROM session
        """
        cursor.execute(sql_delete)
        db.conn.commit()
        controller.show_frame(Login)

    def insert_orderdata(self,string):
        db = Database()
        cursor = db.conn.cursor()
        sql_delete = """
        DELETE FROM orders
        """
        cursor.execute(sql_delete)
        db.conn.commit()
        json_obj = json.loads(string)
        for order_data in json_obj['posts']:
            if(str(order_data['status']) == '0'):
                order_status = 'PENDING'
            elif(str(order_data['status']) == '1'):
                order_status = 'ACCEPTED'
            elif(str(order_data['status']) == '2'):
                order_status = 'DELIVERED'
            elif(str(order_data['status']) == '3'):
                order_status = 'DECLINE'
            sql_insert = """
            INSERT INTO orders VALUES (NULL,'"""+str(order_data['user_id'])+"""','"""+str(order_data['order_detail_id'])+"""',
            '"""+str(order_status)+"""','"""+str(order_data['status_time'])+"""','"""+str(order_data['firstname'])+"""','"""+str(order_data['lastname'])+"""',
            '"""+str(order_data['add_1'])+"""','"""+str(order_data['add_2'])+"""','"""+str(order_data['city'])+"""','"""+str(order_data['post_code'])+"""','"""+str(order_data['loyalty_point'])+"""',
            '"""+str(order_data['about_order'])+"""','"""+str(order_data['payment_method'])+"""','"""+str(order_data['decline_reason'])+"""','"""+str(order_data['order_time'])+"""',
            '"""+str(order_data['total_price'])+"""','"""+str(order_data['currency'])+"""','"""+str(order_data['date_order'])+"""')
            """
            cursor.execute(sql_insert)
            db.conn.commit()
    
    def get_Records(self,url):
        url = url
        print(url)
        request = urllib2.Request(url)
        response = urllib2.urlopen(request)
        return response

    def set_Col(self):
        self.list = ttk.Treeview(self)
        self.scroll = ttk.Scrollbar(self, command=self.list.yview)
        self.list.pack_forget()
        self.list['columns']=('Customer', 'Address 1', 'City', 'Post Code', 'Order Date/Time', 'About Order', 'Payment Method', 'Time Or Reason','Total', 'status')
        self.list.heading("#0", text='ID', anchor='w')
        self.list.column("#0", anchor="w", width=50)
        self.list.heading('Customer', text='Customer')
        self.list.column('Customer', anchor='center', width=150)
        self.list.heading('Address 1', text='Address 1')
        self.list.column('Address 1', anchor='center', width=150)
        self.list.heading('City', text='City')
        self.list.column('City', anchor='center', width=100)
        self.list.heading('Post Code', text='Post Code')
        self.list.column('Post Code', anchor='center', width=100)
        self.list.heading('Order Date/Time', text='Order Date/Time')
        self.list.column('Order Date/Time', anchor='center', width=150)
        self.list.heading('About Order', text='About Order')
        self.list.column('About Order', anchor='center', width=200)
        self.list.heading('Payment Method', text='Payment Method')
        self.list.column('Payment Method', anchor='center', width=100)
        self.list.heading('Time Or Reason', text='Time Or Reason')
        self.list.column('Time Or Reason', anchor='center', width=100)
        self.list.heading('Total', text='Total')
        self.list.column('Total', anchor='center', width=100)
        self.list.heading('status', text='Status')
        self.list.column('status', anchor='center', width=100)
        self.scroll.pack(side=RIGHT, fill=Y)
        self.list.pack(expand=YES, fill=BOTH)
        self.list.configure(yscrollcommand=self.scroll.set)
        '''self.noteframe.pack()
        self.notebook.add(self.noteframe,text="View Orders")
        self.notebook.pack()'''
        self.listView()

    def listView(self):
        db = Database()
        cursor = db.conn.cursor()
        sql1 = """
        SELECT * FROM orders
        """
        cursor.execute(sql1)
        sync = self.get_Records(API_URL+"/get_orders.php?total="+str(len(cursor.fetchall()))+"")
        data = sync.read().decode('utf-8')
        self.insert_orderdata(data)
        self.Get_List()
        self.ListViewSet()
        
    def ListViewSet(self):
        threading.Timer(10.0, self.ListViewSet).start()
        db = Database()
        cursor = db.conn.cursor()
        sql1 = """
        SELECT * FROM orders
        """
        cursor.execute(sql1)
        sync = self.get_Records(API_URL+"/get_orders.php?total="+str(len(cursor.fetchall()))+"")
        data = sync.read().decode('utf-8')
        json_obj = json.loads(data)
        for order_data in json_obj['posts']:
            if(str(order_data['status_time']) == 'New'):
                if os.path.isfile("PetroFDS.db"):
                    self.list.delete(*self.list.get_children())
                    self.insert_orderdata(data)
                    self.Get_List()
                    print(str(order_data['total_order']))
                    tkinter.messagebox.showinfo( "New Order", ""+str(order_data['total_order'])+" New Order Received")
                    sql = """
                    SELECT * FROM orders ORDER BY id DESC LIMIT """+str(order_data['total_order'])+"""
                    """
                    cursor.execute(sql)

                    rows = cursor.fetchall()
                    for row in rows:
                        self.Popup(row[2])
            else:
                self.insert_orderdata(data)
            break
    
    def Get_List(self):
        db = Database()
        cursor = db.conn.cursor()
        sql = """
        SELECT * FROM orders
        """
        cursor.execute(sql)

        rows = cursor.fetchall()
        for row in rows:
            print(row[3])
            currency = row[17]
            if(row[4] == 'Old'):
                if(row[3] == 'PENDING'):
                    self.list.insert('', 'end', tags = ('pendingrow',), text=row[2], values=(row[5]+''+row[6], row[7], row[9], row[10], row[18], row[12], row[13], 'Not Available', currency+row[16], row[3]))
                elif(row[3] == 'ACCEPTED'):
                    self.list.insert('', 'end', tags = ('acceptrow',), text=row[2], values=(row[5]+''+row[6], row[7], row[9], row[10], row[18], row[12], row[13], row[15], currency+row[16], row[3]))
                elif(row[3] == 'DELIVERED'):
                    self.list.insert('', 'end', tags = ('deliveredrow',), text=row[2], values=(row[5]+''+row[6], row[7], row[9], row[10], row[18], row[12], row[13], 'Not Available', currency+row[16], row[3]))
                elif(row[3] == 'DECLINE'):
                    self.list.insert('', 'end', tags = ('declinerow',), text=row[2], values=(row[5]+''+row[6], row[7], row[9], row[10], row[18], row[12], row[13], row[14], currency+row[16], row[3]))
            elif(row[4] == 'New'):
                if(row[3] == 'PENDING'):
                    self.list.insert('', 'end', tags = ('pendingrow',), text=row[2], values=(row[5]+''+row[6], row[7], row[9], row[10], row[18], row[12], row[13], 'Not Available', currency+row[16], row[3]))
                elif(row[3] == 'ACCEPTED'):
                    self.list.insert('', 'end', tags = ('acceptrow',), text=row[2], values=(row[5]+''+row[6], row[7], row[9], row[10], row[18], row[12], row[13], row[15], currency+row[16], row[3]))
                elif(row[3] == 'DELIVERED'):
                    self.list.insert('', 'end', tags = ('deliveredrow',), text=row[2], values=(row[5]+''+row[6], row[7], row[9], row[10], row[18], row[12], row[13], 'Not Available', currency+row[16], row[3]))
                elif(row[3] == 'DECLINE'):
                    self.list.insert('', 'end', tags = ('declinerow',), text=row[2], values=(row[5]+''+row[6], row[7], row[9], row[10], row[18], row[12], row[13], row[14], currency+row[16], row[3]))
            self.list.tag_configure('declinerow', background='red')
            self.list.tag_configure('pendingrow', background='yellow')
            self.list.tag_configure('acceptrow', background='pink')
            self.list.tag_configure('deliveredrow', background='green')
            self.list.bind('<Double-1>',self.SelectOption, add='')
            self.list.bind('<Return>',self.SelectOption, add='')
        
        
    def SelectOption(self,event):
        item = self.list.selection()[0]
        id_list = self.list.item(item,"text")
        self.option = Toplevel()
        self.option.geometry("300x250")
        self.option.title("Select Options")
        self.option.iconbitmap(r'favicon.ico')

        db = Database()
        cursor = db.conn.cursor()
        sql_delete = """
        DELETE FROM order_invoice
        """
        cursor.execute(sql_delete)
        db.conn.commit()
        sql = """
        SELECT * FROM order_invoice WHERE id='"""+str(id_list)+"""'
        """
        cursor.execute(sql)
        if(str(len(cursor.fetchall())) == '0'):
            sync = self.get_Records(API_URL+"/get_invoice.php?id="+str(id_list)+"")
            data = sync.read().decode('utf-8')
            json_obj = json.loads(data)
            for orders in json_obj['posts']:
                sql_insert_invoice = """
                INSERT INTO order_invoice VALUES (NULL,'"""+str(id_list)+"""','"""+str(orders['user_id'])+"""','"""+str(orders['quantity'])+"""','"""+str(orders['price'])+"""','"""+self.clean(orders['name'])+"""','"""+orders['currency']+"""','"""+str(orders['delivery_charges'])+"""','"""+str(orders['price_all'])+"""')
                """
                cursor.execute(sql_insert_invoice)
                db.conn.commit()       
        self.top = Frame(self.option)
        self.bottom = Frame(self.option)
        self.top.pack(side=TOP)
        self.bottom.pack(side=BOTTOM, fill=BOTH, expand=True)

        self.detail_button = ttk.Button(self.option, text="View Detail", command=lambda: self.PopupReceipt(id_list))
        self.detail_button.pack(in_=self.top, side=LEFT, pady=(90,0), padx=(0,20))
        
        self.print_button = ttk.Button(self.option, text="Accept/Decline", command=lambda: self.Popup(id_list))
        self.print_button.pack(in_=self.top, side=LEFT, pady=(90,0), padx=(20,0))

    def itersplit_into_x_chunks(self,string,x=16):
        return wrap(string,x)
            
        
    def PopupReceipt(self,item):
        self.option.destroy()
        self.top = Toplevel()
        self.top.iconbitmap(r'favicon.ico')
        self.top.title('Order ID: '+item)

        text2 = Text(self.top, width=80, undo=True)
        scroll = Scrollbar(self.top, command=text2.yview)
        text2.configure(yscrollcommand=scroll.set)
        text2.tag_configure('bold_italics', font=('Arial', 12, 'bold', 'italic'), justify='center')
        text2.tag_configure('big', font=('Verdana', 20, 'bold'), justify='center')
        text2.tag_configure('lines', font=('Times', 12, 'bold'), justify='left', foreground='black')
        text2.tag_configure('color', foreground='#476042', font=('Tempus Sans ITC', 12, 'bold'))
        table = Texttable()
        table.set_deco(Texttable.HEADER)
        table.set_cols_dtype(['i',  # integer
                              't',  # text
                              'i']) # integer
        table.set_cols_align(["c", "l", "l"])
        header = ['Qty', 'Product', 'Total']
        table.header(header)
        x = 1;
        db = Database()
        cursor = db.conn.cursor()
        sql = """
        SELECT id, order_detail_id, user_id, quantity, price, name, currency, delivery_charges, price_all FROM order_invoice WHERE order_detail_id='"""+item+"""'
        """
        cursor.execute(sql)

        rows = cursor.fetchall()
        for i, row in enumerate(rows):
            currency = row[6]
            total_single = float(row[4])*float(row[3])
            receiptdata = [row[3],row[5],currency+str(total_single)]
            totals = row[8]
            x = x + 1
            dev_charge = row[7];
            table.add_row(receiptdata)
        table.set_cols_width([10,22,12])
        text2.insert(END,table.draw()+'\n')
        text2.insert(END,'===================================================  \n')
        dev_charge = 0
        text2.insert(END,'Delivery-Charges:                      '+currency+str(dev_charge)+'  \n')
        text2.insert(END,'Net-Total:                             '+currency+str(totals)+'  \n')
        text2.insert(END,'===================================================  \n')
        sql_setting = """
        SELECT * FROM settings
        """
        cursor.execute(sql_setting)

        rows_setting = cursor.fetchall()
        for setting in rows_setting:
            text2.insert(END,setting[2]+' \n')
        self.button = ttk.Button(text2, text="Print", command=lambda: self.Print(item,text2.get('1.0', END)))
        self.button.pack()
        text2.window_create(END, window=self.button)
        text2.pack(side=LEFT, expand=True, fill=BOTH)
        scroll.pack(side=RIGHT, fill=Y)

    def Print(self,order_id,data):
        file_name = order_id+'.txt';
        open(file_name,'w').write(data)
        scale_factor = 20
        font_heading = win32ui.CreateFont({
           "name": "Arial Unicode MS", # a font name
           "height": int(scale_factor * 4), # 10 pt
           "weight": 500, # 400 = normal
        })
        font = win32ui.CreateFont({
           "name": "Arial Unicode MS", # a font name
           "height": int(scale_factor * 2), # 10 pt
           "weight": 500, # 400 = normal
        })
        font_afterline = win32ui.CreateFont({
           "name": "Arial Unicode MS", # a font name
           "height": int(scale_factor * 14), # 10 pt
           "weight": 500, # 400 = normal
        })
        font_detail = win32ui.CreateFont({
           "name": "Arial Unicode MS", # a font name
           "height": int(scale_factor * 1.5), # 10 pt
           "weight": 500, # 400 = normal
        })
        X_Heading=60; Y_Heading=150
        X_ID=150; Y_ID=225
        X_Contact=140; Y_Contact=280
        X_DateTime=130; Y_DateTime=330
        X_End=50; Y_End=550
        X_Details=100; Y_Details=-2200
        X_Details1=100; Y_Details1=-2500
        X_Details2=100; Y_Details2=-2800
        X_Details3=100; Y_Details3=-3100
        X_Total=1200; Y_Total=-800
        hDC = win32ui.CreateDC()
        hDC.CreatePrinterDC(win32print.GetDefaultPrinter())
        hDC.StartDoc("Order#"+order_id)
        hDC.SelectObject(font_heading)
        hDC.StartPage()
        hDC.TextOut(X_Heading,Y_Heading,"PetroFDS")
        hDC.SelectObject(font)
        hDC.TextOut(X_ID,Y_ID,"Order Receipt# "+order_id)
        hDC.SelectObject(font_detail)
        hDC.TextOut(X_Contact,Y_Contact,"Contact Us At: +12345678910")
        hDC.TextOut(X_DateTime,Y_DateTime,"Date & Time: "+time.strftime("%c"))
        hDC.SetMapMode (win32con.MM_TWIPS)
        pen = win32ui.CreatePen(win32con.PS_DASH, 20, RGB(148, 37, 37))
        hDC.SetBkMode(win32con.TRANSPARENT)
        hDC.SelectObject(pen)
        hDC.MoveTo(-2000, -2800)
        hDC.LineTo(4000, -2800)
        hDC.SelectObject(font_afterline)
        x = 1
        
        db = Database()
        cursor = db.conn.cursor()
        sql = """
        SELECT id, order_detail_id, user_id, quantity, price, name, (SELECT sum(price) FROM order_invoice WHERE order_detail_id='"""+order_id+"""') total FROM order_invoice WHERE order_detail_id='"""+order_id+"""'
        """
        cursor.execute(sql)

        rows = cursor.fetchall()
        for row in rows:
                totals = row[6]
                y = 10000*x
                x = x + 1
        dr = open(file_name,'r').read()
        hDC.DrawText(dr,(150,-3000,y,-y),win32con.DT_LEFT)
        hDC.EndPage()
        hDC.EndDoc()     

    def Popup(self,ids):
        self.top = Toplevel()
        self.top.geometry("600x600")
        self.top.title('Order#'+ids)
        self.top.iconbitmap(r'favicon.ico')

        head = ttk.Label(self.top, text="Payment Details", font=TITLE_FONT)
        head.pack()

        frm = LabelFrame(self.top, labelwidget=head)
        frm.pack(expand=True, fill='x', anchor = "w", ipadx=10, ipady=5, padx=10, pady=0, side="top")

        db = Database()
        cursor = db.conn.cursor()

        sql = """
        SELECT * FROM orders WHERE order_detail_id="""+ids+"""
        """
        cursor.execute(sql)

        rows = cursor.fetchall()
        for row in rows:

            self.lbl_name = Label(frm, text="Full Name: "+row[5]+""+row[6], font=TITLE_FONT)
            self.lbl_name.pack(pady=(25, 0))
            
            #self.lbl_name_text = Label(frm, text=row[5]+""+row[6], font=NORMAL_FONT)
            #self.lbl_name_text.pack(pady=(25, 0))

            self.lbl_add1 = Label(frm, text="Address 1: "+row[7], font=TITLE_FONT)
            self.lbl_add1.pack(pady=(25, 0))

            #self.lbl_add1_text = Label(frm, text=row[7], font=NORMAL_FONT)
            #self.lbl_add1_text.pack(pady=(25, 0))

            self.lbl_add2 = Label(frm, text="Address 2: "+row[8], font=TITLE_FONT)
            self.lbl_add2.pack(pady=(25, 0))

            #self.lbl_add2_text = Label(frm, text=row[8], font=SMALL_FONT)
            #self.lbl_add2_text.pack(pady=(25, 0))

            self.lbl_city = Label(frm, text="City: "+row[9], font=TITLE_FONT)
            self.lbl_city.pack(pady=(25, 0))

            #self.lbl_city_text = Label(frm, text=row[9], font=NORMAL_FONT)
            #self.lbl_city_text.pack(pady=(25, 0))

            self.lbl_postcode = Label(frm, text="Post Code: "+row[10], font=TITLE_FONT)
            self.lbl_postcode.pack(pady=(25, 0))

            #self.lbl_postcode_text = Label(frm, text=row[10], font=NORMAL_FONT)
            #self.lbl_postcode_text.pack(pady=(25, 0))
        
        self.button_accept = ttk.Button(self.top, text="Accept", command=lambda: self.Accept(ids))
        self.button_accept.pack(padx=(180, 0),pady=(0, 50),side=LEFT)

        self.button_decline = ttk.Button(self.top, text="Decline", command=lambda: self.Decline(ids))
        self.button_decline.pack(padx=(0, 180),pady=(0, 50),side=RIGHT)

        print(head.cget("text"))

    def Accept(self,ids):
        self.top.destroy()
        self.acc = Toplevel()
        self.acc.geometry("300x400")
        self.acc.title('Accepting Order')
        self.acc.iconbitmap(r'favicon.ico')
        
        self.lbl_time = Label(self.acc, text="Select Time in Which Order is Placed:-", font=CUSTOM_FONT)
        self.lbl_time.pack(pady=(25, 0))

        list = ['2', '4', '5', '10', '20', '30', '40', '50', '60', '80', '100', '120'];
        
        self.time = ttk.Combobox(self.acc, width=15, values=list, font=CUSTOM_FONT)
        self.time.pack()
        
        self.button_accept = ttk.Button(self.acc, text="Accept", command=lambda: self.AcceptOrder(self.time.get(),ids))
        self.button_accept.pack(pady=(5, 0))
        
    def Decline(self,ids):
        self.top.destroy()
        self.dec = Toplevel()
        self.dec.geometry("500x500")
        self.dec.title('Decline Order')
        self.dec.iconbitmap(r'favicon.ico')

        self.lbl_reason = Label(self.dec, text="Reason to decline an order:-", font=CUSTOM_FONT)
        self.lbl_reason.pack(pady=(25, 0))

        self.reason = Text(self.dec, height=20, width=40, font=CUSTOM_FONT)
        self.reason.pack(pady=(25, 0))

        self.button_decline = ttk.Button(self.dec, text="Decline", command=lambda: self.DeclineOrder(self.reason.get('1.0', END),ids))
        self.button_decline.pack(pady=(5, 0))

    def AcceptOrder(self,time,ids):
        url = API_URL+"/get_orders_status.php"
        data = {"status": "1","time": time,"id": ids}
        data = urllib.parse.urlencode(data)
        request = urllib2.Request(url + '?' + data)
        response = urllib2.urlopen(request)
        self.UpdateAll()

    def DeclineOrder(self,reason,ids):
        url = API_URL+"/get_orders_status.php"
        data = {"status": "3","reason": str(reason),"id": ids}
        data = urllib.parse.urlencode(data)
        request = urllib2.Request(url + '?' + data)
        response = urllib2.urlopen(request)
        self.UpdateAll()

    def UpdateAll(self):
        db = Database()
        cursor = db.conn.cursor()
        sql1 = """
        SELECT * FROM orders
        """
        cursor.execute(sql1)
        sync = self.get_Records(API_URL+"/get_orders.php?total="+str(len(cursor.fetchall()))+"")
        data = sync.read().decode('utf-8')
        json_obj = json.loads(data)
        for order_data in json_obj['posts']:
            self.list.delete(*self.list.get_children())
            self.insert_orderdata(data)
            self.Get_List()
    
    def rClicker(self,e):
        try:
            def rClick_Copy(e, apnd=0):
                e.widget.event_generate('<Control-c>')

            def clean(raw_html):

              cleanr =re.compile('<.*?>')

              cleantext = re.sub(cleanr,'', raw_html)

              return cleantext
            
            def rClick_Detail(e):
                item = self.list.selection()[0]
                print("you clicked on", self.list.item(item,"text"))
                self.top = Toplevel()
                self.top.geometry("550x600")
                db = Database()
                cursor = db.conn.cursor()
                sql = """
                SELECT * FROM orders WHERE id='"""+str(self.list.item(item,"text"))+"""'
                """
                cursor.execute(sql)

                rows = cursor.fetchall()
                for row in rows:
                    self.top.title(row[1]+' '+row[2])

                sync = self.get_Records(API_URL+"/get_invoice.php?id="+str(self.list.item(item,"text"))+"")
                data = sync.read().decode('utf-8')
                json_obj = json.loads(data)
                for invoice_data in json_obj['posts']:
                    self.msg = Message(self.top, text=clean(invoice_data['payment_method']))
                    self.msg.pack()
                    self.msg_1 = Message(self.top, text=clean(invoice_data['about_order']))
                    self.msg_1.pack()

                self.button = ttk.Button(self.top, text="Print")
                self.button.pack()

            def rClick_Print(e):
                item = self.list.selection()[0]
                print("you clicked on", self.list.item(item,"text"))

            e.widget.focus()

            nclst=[
                   (' Copy', lambda e=e: rClick_Copy(e)),
                   (' View Details', lambda e=e: rClick_Detail(e)),
                   (' Print', lambda e=e: rClick_Print(e)),
                    ]

            rmenu = Menu(None, tearoff=0, takefocus=0)

            for (txt, cmd) in nclst:
                rmenu.add_command(label=txt, command=cmd)

            rmenu.tk_popup(e.x_root+40, e.y_root+10,entry="0")

        except TclError:
            print (' - rClick menu, something wrong')
            pass

        return "break"


    def rClickbinder(self,r):

        try:
            for b in [ 'Text', 'Entry', 'Listbox', 'Label']: #
                r.bind_class(b, sequence='<Button-3>',
                             func=rClicker, add='')
        except TclError:
            print (' - rClickbinder, something wrong')
            pass
    
class PageTwo(tk.Frame):

    def __init__(self, parent, controller):
        tk.Frame.__init__(self, parent)
        label = tk.Label(self, text="This is page 2", font=TITLE_FONT)
        label.pack(side="top", fill="x", pady=10)
        button = tk.Button(self, text="Go to the start page",
                           command=lambda: controller.show_frame(StartPage))
        button.pack()


if __name__ == "__main__":
    app = PetroFDS()
    app.iconbitmap(r'favicon.ico')
    app.mainloop()
