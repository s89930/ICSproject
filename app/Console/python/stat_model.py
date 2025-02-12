import pandas as pd
import numpy as np
import statsmodels.api as sm
from statsmodels.tsa.api import VAR
import pickle, warnings, os, sys
warnings.filterwarnings('ignore')

# data order: (1)ph (2)temp (3)ec (4)ss (5)cod
datas = sys.argv[1]
loc = sys.argv[2]

# rb: 用2位元度入
path = os.getcwd() + "/public/models/" + loc
with open(path, 'rb') as file:
    model = pickle.load(file)

# data processing
datas = datas[1:-1]+','
datas = datas.replace('[', '').replace(',', ' ').split(']')
data_arr = []
for d in datas:
    temp_arr = []
    d = d.split(' ')
    for i in range(len(d)):
        if d[i] == "":
            continue
        else:
            temp_arr.append(float(d[i].strip()))
    if temp_arr:
        data_arr.append(temp_arr)

# sliding window, window size=31 
input = np.array(data_arr)

# array type
prediction = np.reshape(model.get('model_fitted').forecast(input, steps=1), -1)
print(prediction[-1])
file.close()


