from graphviz import Digraph

# Definición del autómata
states = {'q0', 'q1', 'q2'}
alphabet = {'a', 'b'}
initial_state = 'q0'
accepting_states = {'q2'}

transitions = {
    'q0': {'a': 'q0', 'b': 'q1'},
    'q1': {'a': 'q0', 'b': 'q2'},
    'q2': {'a': 'q0', 'b': 'q1'},
}

# Crear el grafo con Graphviz
dot = Digraph(comment='Automata for Language: Strings ending with "ab"')
dot.attr(rankdir='LR')  # Dirección de izquierda a derecha

for state in states:
    if state in accepting_states:
        dot.node(state, shape='doublecircle')
    else:
        dot.node(state)

for from_state, transitions_dict in transitions.items():
    for symbol, to_state in transitions_dict.items():
        dot.edge(from_state, to_state, label=symbol)

# Mostrar el grafo en formato PNG
dot.format = 'png'
dot.render('finite_automaton', cleanup=True, view=True)


